<?php

class Model_Orm_Comment extends Orm\Model
{
   protected static $_table_name = 'comments';
   protected static $_primary_key = array('id');
   protected static $_properties = array(
	    'id',
	    'comment',
        'event_id',
        'user_id',
	     'created'
	    );
    protected static $_belongs_to =
			array(
			    'event' => array(
				'key_from' => 'event_id',
				'model_to' => 'Model_Orm_Event',
				'key_to' => 'id'),

                'user' => array(
                'key_from' => 'user_id',
                'model_to' => 'Model_Orm_User',
                'key_to' => 'id')
			);
    public static function validate($factory) {
	$val = Validation::forge($factory);
	$val->add_field('title', 'Title', 'required|max_length[255]');
	return $val;
    }
}
