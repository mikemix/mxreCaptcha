<?php return [
    'form_elements' => [
        'factories' => [
            'mxreCaptcha' => mxreCaptcha\Factory\Form\Element\ReCaptchaFactory::class,
        ],
    ],
    'validators' => [
        'factories' => [
            mxreCaptcha\Validator\ReCaptcha::class => mxreCaptcha\Factory\Validator\ReCaptchaFactory::class,
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'reCaptchaElement' => mxreCaptcha\View\Helper\ReCaptchaElement::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'mxreCaptcha/element' => __DIR__ . '/../view/element.phtml',
        ],
    ],
];
