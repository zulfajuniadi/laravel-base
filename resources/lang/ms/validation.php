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

    'accepted'             => ':attribute mestilah diterima.',
    'active_url'           => ':attribute bukan URL yang sah.',
    'after'                => 'tarikh :attribute mestilah selepas :date.',
    'alpha'                => ':attribute hanya boleh mengandungi huruf.',
    'alpha_dash'           => ':attribute boleh mengandungi huruf, nombor, dan sengkang.',
    'alpha_num'            => ':attribute boleh mengandungi huruf dan nombor.',
    'array'                => ':attribute mestilah berbentuk array.',
    'before'               => 'tarikh :attribute mestilah sebelum :date.',
    'between'              => [
        'numeric' => ':attribute mesti mengandungi antara :min dan :max.',
        'file'    => ':attribute mesti mengandungi antara :min dan :max kilobait.',
        'string'  => ':attribute mesti mengandungi antara :min dan :max aksara.',
        'array'   => ':attribute mesti mengandungi antara :min dan :max perkara.',
    ],
    'boolean'              => ':attribute mestilah betul atau salah.',
    'confirmed'            => ':attribute pengesahan tidak sama.',
    'date'                 => ':attribute bukan tarikh yang sah.',
    'date_format'          => ':attribute tidak mengikut format :format.',
    'different'            => ':attribute dan :other mestilah berbeza.',
    'digits'               => ':attribute mestilah :digits angka.',
    'digits_between'       => ':attribute mesti mengandungi antara :min dan :max angka.',
    'email'                => ':attribute mestilah alamat e-mel yang sah.',
    'exists'               => ':attribute yang dipilih tidak sah.',
    'filled'               => ':attribute adalah diperlukan.',
    'image'                => ':attribute mestilah gambar.',
    'in'                   => ':attribute yang dipilih tidak sah.',
    'integer'              => ':attribute mestilah integer.',
    'ip'                   => ':attribute mestilah alamat IP yang sah.',
    'json'                 => ':attribute mestilah rentetan JSON yang sah.',
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih daripada :max.',
        'file'    => ':attribute tidak boleh lebih daripada :max kilobait.',
        'string'  => ':attribute tidak boleh lebih daripada :max aksara.',
        'array'   => ':attribute tidak boleh lebih daripada :max perkara.',
    ],
    'mimes'                => ':attribute fail mestilah antara: :values.',
    'min'                  => [
        'numeric' => ':attribute mestilah kurang daripada :min.',
        'file'    => ':attribute mestilah kurang daripada :min kilobait.',
        'string'  => ':attribute mestilah kurang daripada :min aksara.',
        'array'   => ':attribute mestilah kurang daripada :min perkara.',
    ],
    'not_in'               => ':attribute tidak sah.',
    'numeric'              => ':attribute mestilah angka.',
    'regex'                => 'format :attribute tidak sah.',
    'required'             => ':attribute diperlukan.',
    'required_if'          => ':attribute diperlukan apabila :other adalah :value.',
    'required_unless'      => 'Medan :attribute diperlukan kecuali :other adalah :values.',
    'required_with'        => ':attribute diperlukan apabila :values diisi.',
    'required_with_all'    => ':attribute diperlukan apabila :values diisi.',
    'required_without'     => ':attribute diperlukan apabila :values tidak diisi.',
    'required_without_all' => ':attribute diperlukan apabila kesemua :values tidak diisi.',
    'same'                 => ':attribute dan :other mestilah sama.',
    'size'                 => [
        'numeric' => ':attribute mestilah :size.',
        'file'    => ':attribute mestilah :size kilobait.',
        'string'  => ':attribute mestilah :size aksara.',
        'array'   => ':attribute mestilah mengandungi :size perkara.',
    ],
    'string'               => ':attribute mestilah rentetan.',
    'timezone'             => ':attribute mestilah zon masa yang sah.',
    'unique'               => ':attribute telahpun diambil.',
    'url'                  => 'format :attribute tidak sah.',
    'matches_hashed_password' => ':attribute tidak sah',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];