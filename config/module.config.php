<?php return [
    'form_elements' => [
        'factories' => [
            'mxreCaptcha' => mxreCaptcha\Factory\Form\Element\ReCaptchaFactory::class,
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo'
            ],
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
