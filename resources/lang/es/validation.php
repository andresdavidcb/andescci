<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'El campo :attribute debe ser aceptado.',
    'accepted_if' => 'El campo :attribute debe ser aceptado cuando :other es :value.',
    'active_url' => ':attribute no es una URL válida.',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El campo :debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El campo :attribute sólo puede tener letras.',
    'alpha_dash' => 'El campo :attribute solamente puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El campo :attribute solamente puede contener letras y números.',
    'array' => 'El campo :attribute debe ser un arreglo.',
    'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'file' => 'El campo :attribute debe estar entre :min y :max kilobytes.',
        'string' => 'El campo :attribute debe tener entre :min y :max caracteres.',
        'array' => 'El campo :attribute debe tener entre :min y :max elementos.',
    ],
    'boolean' => 'El campo :attribute debe ser falso o verdadero.',
    'confirmed' => 'El campo de confirmación :attribute no coincide.',
    'current_password' => 'La contraseña actual es incorrecta.',
    'date' => 'El campo :attribute no es una fecha válida.',
    'date_equals' => 'El campo :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El campo :attribute no coincide con el formato :format.',
    'different' => 'El campo :attribute y :other deben ser diferentes.',
    'digits' => 'El campo :attribute debe tener :digits dígitos.',
    'digits_between' => 'El campo :attribute debe estar entre :min y :max dígitos.',
    'dimensions' => 'El campo :attribute tiene dimensiones de imagen inválidas.',
    'distinct' => 'El campo :attribute tiene un valor duplicado.',
    'email' => 'El campo :attribute debe ser un correo electrónico válido.',
    'ends_with' => 'El campo :attribute debe terminar en :values.',
    'exists' => 'El campo seleccionado :attribute es inválido.',
    'file' => 'El campo :attribute debe ser un archivo.',
    'filled' => 'El campo :attribute debe tener un valor.',
    'gt' => [
        'numeric' => 'El campo :attribute debe ser mayor a :value.',
        'file' => 'El campo :attribute debe ser mayor a :value kilobytes.',
        'string' => 'El campo :attribute debe ser mayor a :value caracteres.',
        'array' => 'El campo :attribute debe tener más de :value elementos.',
    ],
    'gte' => [
        'numeric' => 'El campo :attribute debe ser mayor que o igual :value.',
        'file' => 'El campo :attribute debe ser mayor que o igual :value kilobytes.',
        'string' => 'El campo :attribute debe ser mayor que o igual :value caracteres.',
        'array' => 'El campo :attribute debe tener :value elementos o más.',
    ],
    'image' => 'El campo :attribute debe ser una imagen.',
    'in' => 'El campo seleccionado :attribute es inválido.',
    'in_array' => 'El campo :attribute no existe en :other.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'ip' => 'El campo :attribute debe ser dirección IP válida.',
    'ipv4' => 'El campo :attribute debe ser dirección IPv4 válida.',
    'ipv6' => 'El campo :attribute debe ser IPv6 address.',
    'json' => 'El campo :attribute debe ser JSON string.',
    'lt' => [
        'numeric' => 'El campo :attribute debe ser menos que :value.',
        'file' => 'El campo :attribute debe ser menos que :value kilobytes.',
        'string' => 'El campo :attribute debe ser menos que :value characters.',
        'array' => 'El campo :attribute tiene menos de :value elementos.',
    ],
    'lte' => [
        'numeric' => 'The :attribute  debe ser menos than or equal to :value.',
        'file' => 'The :attribute debe ser menos o igual que :value kilobytes.',
        'string' => 'The :attribute debe ser menos than or equal to :value characters.',
        'array' => 'The :attribute no debe tener más de :value elementos.',
    ],
    'max' => [
        'numeric' => 'El campo :attribute no debería ser más grande que :max.',
        'file' => 'El campo :attribute no debería pesar más de :max kilobytes.',
        'string' => 'El campo :attribute no debería tener más de :max caracteres.',
        'array' => 'El campo :attribute no debería tener más de :max elementos.',
    ],
    'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'mimetypes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'numeric' => 'El campo :attribute debe ser mínimo :min.',
        'file' => 'El campo :attribute debe ser por lo menos :min kilobytes.',
        'string' => 'El campo :attribute debe ser por lo menos :min caracteres.',
        'array' => 'El campo :attribute debe tener al menos :min elementos.',
    ],
    'multiple_of' => 'El campo :attribute must be a multiple of :value.',
    'not_in' => 'El campo selected :attribute is invalid.',
    'not_regex' => 'El formato del campo :attribute es inválido.',
    'numeric' => 'El campo :attribute debe ser de tipo numérico.',
    'password' => 'Lacontraseña es incorrecta.',
    'present' => 'El campo :attribute debe ser presente.',
    'regex' => 'El formato del campo :attribute  es inválido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_if' => 'El campo :attribute es obligatorio when :other is :value.',
    'required_unless' => 'El campo :attribute es obligatorio unless :other is in :values.',
    'required_with' => 'El campo :attribute es obligatorio when :values is present.',
    'required_with_all' => 'El campo :attribute es obligatorio when :values are present.',
    'required_without' => 'El campo :attribute es obligatorio when :values is not present.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de :values están presentes.',
    'prohibited' => 'El campo :attribute no está permitido.',
    'prohibited_if' => 'El campo :attribute está prohibido si :other es :value.',
    'prohibited_unless' => 'El campo :attribute no está permitido, a menos que :other esté en :values.',
    'prohibits' => 'El campo :attribute prohibe :other from estar presente.',
    'same' => 'El campo :attribute y :other deben coincidir.',
    'size' => [
        'numeric' => 'El campo :attribute debe ser de :size.',
        'file' => 'El campo :attribute debe ser :size kilobytes.',
        'string' => 'El campo :attribute debe ser :size caracteres.',
        'array' => 'El campo :attribute debe contener :size elementos.',
    ],
    'starts_with' => 'El campo :attribute con uno de los siguientes valores: :values',
    'string' => 'El campo :attribute debe ser una cadena.',
    'timezone' => 'El campo :attribute debe ser una zona horaria válida.',
    'unique' => 'El campo :attribute ya existe.',
    'uploaded' => 'Error al subir :attribute.',
    'url' => 'El formato de :attribute es inválido.',
    'uuid' => 'El campo :attribute debe ser un UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
