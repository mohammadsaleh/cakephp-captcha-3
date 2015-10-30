<?php
/**
 * Helper for Showing the use of Captcha*
 * @author     Arvind Kumar
 * @link       http://www.devarticles.in/
 * @copyright  Copyright © 2014 http://www.devarticles.in/
 * @version 3.0 - Tested OK in Cakephp 2.5.4
 */

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

class CaptchaHelper extends Helper {

/**
 * helpers
 *
 * @var array
 */

  public $helpers = ['Html', 'Form'];

	protected $_defaultConfig = [];

/**
 * Constructor
 *
 * ### Settings:
 *
 * - Get settings set from Component.
 *
 * @param View $View the view object the helper is attached to.
 * @param array $config Settings array Settings array
 */
    public function __construct(View $View, $config = []) {
        parent::__construct($View, $config);
				$this->settings = $config;
    }

    function render($field='captcha', $config=array()) {

        $this->settings = array_merge($this->settings, (array)$config);

        $this->settings['reload_txt'] = isset( $this->settings['reload_txt']) ? __($this->settings['reload_txt']) : __('Can\'t read? Reload');

        $this->settings['clabel'] = isset( $this->settings['clabel']) ? __($this->settings['clabel']) : __('<p>Enter security code shown above:</p>');

        $this->settings['mlabel'] = isset( $this->settings['mlabel']) ? __($this->settings['mlabel']) : __('<p>Answer Simple Math</p>');

        $controller = strtolower( $this->settings['controller']);
        $action =  $this->settings['action'];
        $qstring = array(
            'type' =>   $this->settings['type'],
            'field' =>  $field
        );

        switch( $this->settings['type']):
            case 'image':

                $qstring = array_merge($qstring, array(
                    'width' =>  $this->settings['width'],
                    'height'=>  $this->settings['height'],
                    'theme' =>  $this->settings['theme'],
                    'length' => $this->settings['length'],
                ));

                echo $this->Html->image(array('controller'=>$controller, 'action'=>$action, '?'=> $qstring), array('vspace'=>2));
                echo $this->Html->link( $this->settings['reload_txt'], '#', array('class' => 'creload', 'escape' => false));
                echo $this->Form->input($field, array('autocomplete'=>'off','label'=> $this->settings['clabel'],'class'=>'clabel'));
            break;
            case 'math':
                $qstring = array_merge($qstring, array('type'=>'math'));
                if(isset($this->settings['stringOperation']))   {
                    echo  $this->settings['mlabel'] .  $this->settings['stringOperation'].' = ?';
                }   else    {
                    echo $this->requestAction(array('controller'=>$controller, 'action'=>$action, '?'=> $qstring));
                }
                echo $this->Form->input($field, array('autocomplete'=>'off','label'=>false,'class'=>''));
            break;
        endswitch;
    }
}