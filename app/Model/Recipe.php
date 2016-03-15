<?php
App::uses('AppModel', 'Model');
/**
 * Recipe Model
 *
 * @property Category $Category
 * @property Level $Level
 * @property User $User
 * @property Comment $Comment
 */
class Recipe extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
    public $virtualFields = array('CommentsCount'=>'SELECT COUNT(*) FROM comments as Comment WHERE Comment.recipe_id = Recipe.id');
    // pole wirtualne, gdzie zpaisywane jest liczba komentarzy do kazdego przepisu 
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'To pole nie może być puste',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
				'rule' => array('minLength',5),
				'message' => 'Nazwa musi zawierać co najmniej 5 znaków',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'To pole musi być cyfrą',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'To pole nie może być puste',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            
		),
        	'time' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'To pole nie może być puste',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            ),
            	'level_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'To pole nie może być puste',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            ),
        'picture' => array(
			// http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::uploadError
			'uploadError' => array(
				'rule' => 'uploadError',
				'message' => 'Something went wrong with the file upload',
				'required' => FALSE,
				'allowEmpty' => TRUE,
			),
			// http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::mimeType
		/*	'mimeType' => array(
				'rule' => array('mimeType', array('image/gif','image/png','image/jpg','image/jpeg')),
				'message' => 'Invalid file, only images allowed',
				'required' => FALSE,
				'allowEmpty' => TRUE,
			),
            */
			// custom callback to deal with the file upload
			'processUpload' => array(
				'rule' => 'processUpload',
				'message' => 'Something went wrong processing your file',
				'required' => FALSE,
				'allowEmpty' => TRUE,
				'last' => TRUE,
			)
		)
    );

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Level' => array(
			'className' => 'Level',
			'foreignKey' => 'level_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	private $path;
public function processUpload($check=array()) {
	// deal with uploaded file
	if (!empty($check['picture']['tmp_name'])) {

		// check file is uploaded
		if (!is_uploaded_file($check['picture']['tmp_name'])) {
			return FALSE;
		}

		// build full filename
		$filename = WWW_ROOT . 'rrecipess' . DS . Inflector::slug(pathinfo($check['picture']['name'], PATHINFO_FILENAME)).'.'.pathinfo($check['picture']['name'], PATHINFO_EXTENSION);

		// @todo check for duplicate filename

		// try moving file
		if (!move_uploaded_file($check['picture']['tmp_name'], $filename)) {
			return FALSE;

		// file successfully uploaded
		} else {
			// save the file path relative from WWW_ROOT e.g. uploads/example_filename.jpg
			$this->path = str_replace(DS, "/", str_replace(WWW_ROOT, "", $filename) );
		}
	}

	return TRUE;
}

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'recipe_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
    public function beforeSave($options = array()) {
          // a file has been uploaded so grab the filepath
          
	if (!empty($this->data[$this->alias]['picture'])) {
		$this->data[$this->alias]['picture'] = $this->path;
	}
    
        if (!isset($this->data[$this->alias]['user_id'])) {
			App::uses('CakeSession', 'Model/Datasource');
			$Session = new CakeSession();
            $this->data[$this->alias]['user_id'] = $Session->read('Auth.User.id');
        }
		return parent::beforeSave($options);
    }
}
