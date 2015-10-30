Cakephp Captcha Component 3.0-beta
=============================

A CakePHP 3.x Component to have Captcha support. Tested with CakePHP 3.1.1

Features
--------------------
* Multiple Captcha Support.
	- It simply supports multiple captchas on a page. In different forms or 
	in a single form.
* Model Validation attahced as Behavior
* Image and/or Simple Math Captchas
* Configurable Model Name, Field Name, Captcha Height, Width, Number of 
Characters and Font Face, Size, Angle 
of rotation
* Works without GD Truetype font support
* Random or Fixed Captcha Themes for Image Captchaa
* Random Font face

Demo
--------------------
http://captcha.inimist.com


Installation
--------------------

Place all files bundled in this package in corresponding folders. Then follow instructions given below.

Configuration
--------------------

Open the Controller/Component/CaptchaComponent.php file and make necessary changes in the $settings variable defined near line 125.

Implementation
--------------------

Follow instructions given below to place code in Controller, Model and View files.

###In Controller

Add in the top initialize function of your Controller.

    $this->loadComponent('Captcha', ['field'=>'securitycode']);

Note: "*captcha*" is the default input field name with which we are binding this captcha in examples. Replace with appropriate name.

Add this function in your controller.

    function captcha()	{
        $this->autoRender = false;
        $this->viewBuilder()->layout('ajax');
        $this->Captcha->create();
    }

Add similar logic to the the "action" of your form in your controller. Like ending with comment "//captcha" is the one which is related to the captcha call.

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
	    $this->Users->setCaptcha('securitycode', $this->Captcha->getCode('securitycode')); //captcha
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }


###In Model\Table\UsersTable.php

Add following code in the initialize function:

	$this->addBehavior('Captcha', [
	'field' => 'securitycode',
	'message' => 'Incorrect captcha code value'
	]);

###In View

In the view file, add the following line of code, wherever you want captcha image and input box to be appeared:

    $this->Captcha->render('securitycode');

Also place the following javascript script code in somewhere in your page body so it is called properly and executed. Skip jquery library call if already loaded.

    <script 
    src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></scr
    ipt>
    <script>
    jQuery('.creload').on('click', function() {
        var mySrc = $(this).prev().attr('src');
        var glue = '?';
        if(mySrc.indexOf('?')!=-1)  {
            glue = '&';
        }
        $(this).prev().attr('src', mySrc + glue + new Date().getTime());
        return false;
    });
    </script>

That should be it!

##More examples

###Custom settings:

    echo $this->Form->create($user);
    $custom1['width']=150;
    $custom1['height']=50;
    $custom1['theme']='default';
    $this->Captcha->render($custom1);

###Multiple captchas:

    //form 1
    echo $this->Form->create($user);
    $custom1['width']=150;
    $custom1['height']=50;
    $this->Captcha->render($custom1);

    //form 2, A math captcha, anywhere on the page
    echo $this->Form->create($user);
    $custom2['type']='math';
    $this->Captcha->render($custom2);


**Settings that can be set in your view file:**

* *model*: model name.
* *field*: field name.
* *type*: image or math. If set to 'math' all following settings will be 
obsolete
* *width*: width of image captcha
* *height*: height of image captcha
* *theme*: theme/difficulty image captcha
* *length*: number of characters in image captcha
* *angle*: angle of rotation for characters in image captcha

Additional settings that can be set in Component file.

* *fontAdjustment*: Responsible for the font size relational to Captcha Image 
Size
* *reload_txt*: The phrase which appears as a Captcha Reload link
* *clabel*: Label for Image Captcha Value input field
* *mlabel*: Label for Math Captcha Value input field

Note
--------------------
Math captha is not working right now.

License
--------------------
Licensed under The MIT License
Redistributions of files must retain the given copyright notice.
http://opensource.org/licenses/MIT


Copyright
--------------------
Copyright (C) Arvind Kumar, arvind@inimist.com