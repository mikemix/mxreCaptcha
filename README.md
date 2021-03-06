# mxreCaptcha

[![Build Status](https://scrutinizer-ci.com/g/mikemix/mxreCaptcha/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mikemix/mxreCaptcha/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mikemix/mxreCaptcha/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mikemix/mxreCaptcha/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/mikemix/mxreCaptcha/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mikemix/mxreCaptcha/?branch=master)

Easy ZF2 form integration with reCaptcha v2.0

## Installation

1. Install with Composer `php composer.phar require 'mikemix/mxrecaptcha:~1.0'` (we follow the rules of [Semantic Versioning](http://semver.org/))
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
            'options' => [
                'label' => 'Prove you are human',
            ],
        ]);
        
        // or
        
        // This element behaves as any other element.
        // Aside from that, you can pass custom grecaptcha.render parameters
        // available at the docs
        // https://developers.google.com/recaptcha/docs/display#render_param
        // by setting widget_options key in the options, for example:
        
        $this->add([
            'name' => 'recaptcha',
            'type' => 'mxreCaptcha',
            'options' => [
                'label' => 'Prove you are human',
                'widget_options' => [
                    'theme' => 'dark',
                ],
            ],
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
        $form = $this->getServiceLocator()->get('FormElementManager')
            ->get(AddForm::class);
        
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

```php
<?php
/** @var App\Form\AddForm $form */
$form = $this->form->prepare();
?>

<?= $this->form()->openTag($form) ?>
<?= $this->formCollection($form) ?>
<?= $this->form()->closeTag() ?>
```

## Localization

By default, Polish translation for localized error messages is available out of the box.
To create custom translation for your application, simply copy the `pl.po` file from the `language` directory
and name it accordingly to match your translator `locale` setting (for example `fr_ca.po`). Finally translate
error messages and compile this file to `*.mo`. Put those two files inside the `language` directory.

If you are willing to share your translation, please make a pull request.

## Unit tests

This modules comes up with unit tests. phpUnit is required to run the suite:

1. Clone this repository `git clone https://github.com/mikemix/mxreCaptcha.git`
2. Navigate to it `cd mxreCaptcha`
3. Download composer `php -r "readfile('https://getcomposer.org/installer');" | php`
4. Install dependencies `php composer.phar update`
5. Run suite `phpunit`
