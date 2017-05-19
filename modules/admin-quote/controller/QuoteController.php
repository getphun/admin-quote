<?php
/**
 * Quote management
 * @package admin-quote
 * @version 0.0.1
 * @upgrade true
 */

namespace AdminQuote\Controller;
use AdminQuote\Model\Quote;

class QuoteController extends \AdminController
{
    private function _defaultParams(){
        return [
            'title'             => 'Quote',
            'nav_title'         => 'Component',
            'active_menu'       => 'component',
            'active_submenu'    => 'quote',
            'total'             => 0,
            'pagination'        => []
        ];
    }
    
    public function editAction(){
        if(!$this->user->login)
            return $this->show404();
        
        $id = $this->param->id;
        if(!$id && !$this->can_i->create_quote)
            return $this->show404();
        elseif($id && !$this->can_i->update_quote)
            return $this->show404();
        
        $old = null;
        $params = $this->_defaultParams();
        $params['title'] = 'Create New Quote';
        
        $next = $this->req->getQuery('ref');
        if(!$next)
            $next = $this->router->to('adminQuote');
        $params['next'] = $next;
        
        // get all groups
        $params['groups'] = [];
        $groups = Quote::countGroup('group');
        if($groups)
            $params['groups'] = array_keys($groups);
        
        if($id){
            $params['title'] = 'Edit Quote';
            $object = Quote::get($id, false);
            if(!$object)
                return $this->show404();
            $old = $object;
        }else{
            $object = new \stdClass();
            $object->user = $this->user->id;
        }
        
        if(false === ($form=$this->form->validate('admin-quote', $object)))
            return $this->respond('component/quote/edit', $params);
        
        $object = object_replace($object, $form);
        
        $event = 'updated';
        
        if(!$id){
            $event = 'created';
            $id = Quote::create($object);
        }else{
            Quote::set($object, $id);
        }
        
        $this->fire('quote:'. $event, $object, $old);
        
        $this->redirect($next);
    }
    
    public function indexAction(){
        if(!$this->user->login)
            return $this->loginFirst('adminLogin');
        if(!$this->can_i->read_quote)
            return $this->show404();
        
        $params = $this->_defaultParams();
        $params['quotes'] = [];
        $params['groups'] = [];
        $params['group'] = '';
        $params['here'] = $this->req->url;
        
        // get all groups
        $params['groups'] = [];
        $groups = Quote::countGroup('group');
        if($groups)
            $params['groups'] = array_keys($groups);
        
        $page = $this->req->getQuery('page');
        $rpp  = 20;
        if(!$page)
            $page = 1;
        
        $cond = [];
        $group = $this->req->getQuery('group');
        if($group){
            $params['group'] = $group;
            $cond['group'] = $group;
        }
        
        $params['quotes'] = Quote::get($cond, $rpp, $page, 'created DESC');
        
        $total = Quote::count($cond);
        if($rpp < $total)
            $params['pagination'] = \calculate_pagination($page, $rpp, $total, 10, $cond);
        $params['total'] = $total;
        
        return $this->respond('component/quote/index', $params);
    }
    
    public function removeAction(){
        if(!$this->user->login)
            return $this->show404();
        if(!$this->can_i->remove_quote)
            return $this->show404();
        
        $id = $this->param->id;
        $object = Quote::get($id, false);
        if(!$object)
            return $this->show404();
        
        $this->fire('quote:deleted', $object);
        
        Quote::remove($id);
        
        $next = $this->req->getQuery('ref');
        if($next)
            return $this->redirect($next);
        
        return $this->redirectUrl('adminQuote');
    }
}