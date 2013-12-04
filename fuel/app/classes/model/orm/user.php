<?php

class Model_Orm_User extends Orm\Model {

    protected static $_table_name = 'users';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
	'id',
	'username',
	'password',
	'group',
	'email',
	'last_login',
	'login_hash'
    );
    protected static $_has_many = array(
    'comments' => array(
        'key_from' => 'id',
        'model_to' => 'Model_Orm_Comment',
        'key_to' => 'event_id',
        'cascade_save' => true,
        'cascade_delete' => false)
    );
}
