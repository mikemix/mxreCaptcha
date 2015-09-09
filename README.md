# mxreCaptcha

Easy ZF2 form integration with reCaptcha v2.0



## Installation

1. Install with Composer `php composer.phar require 'mikemix/mxrecaptcha:~1.0'`
2. Load the `mxreCaptcha` module in your `config/application.config.php` file
3. Copy the dist config file `cp vendor/mikemix/mxrecaptcha/config/mxrecaptcha.local.php.dist config/autoload/mxrecaptcha.local.php` and write your private and public key in it
4. You are ready to go!

## Usage

First of all, add the reCaptcha element to your form. Example form class below:

```php
namespace App\Form;

use Zend\Form\Form;

class AddForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'recaptcha',   // or any name of your choice
            'type' => 'mxreCaptcha', // this is important, use our reCaptcha component
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
        ]);
    }
}
```

Example controller

```php
namespace App\Controller;

use App\Form\AddForm;
use Zend\Mvc\Controller\AbstractActionController;

class FormController extends AbstractActionController
{
    public function indexAction()
    {
        $form = $this->getServiceLocator()->get('FormElementManager')->get(AddForm::class);
        
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            
            if ($form->isValid()) {
                $this->flashMessenger()->addSuccessMessage('Success!');
                return $this->redirect()->toRoute('home');
            }
        }
        
        return [
            'form' => $form
        ];
    }
}
```

Example view

```
<?php
/** @var App\Form\AddForm $form */
$form = $this->form->prepare();
?>

<?= $this->form()->openTag($form) ?>

<!-- render the captcha using the reCaptchaElement() view helper! important as is -->
<?= $this->reCaptchaElement($form->get('recaptcha')) ?>

<!-- additional element errors -->
<?= $this->formElementErrors($form->get('recaptcha')) ?>

<?= $this->formElement('submit');

<?= $this->form()->closeTag() ?>
```
