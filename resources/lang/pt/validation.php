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

	"accepted"             => ":attribute deve ser aceito.",
	"active_url"           => ":attribute não é uma URL válida.",
	"after"                => ":attribute deve ser uma data antes de :date.",
	"alpha"                => ":attribute deve conter apenas letras.",
	"alpha_dash"           => ":attribute deve conter apenas letras, números e traços.",
	"alpha_num"            => ":attribute deve conter apenas letras e números.",
	"array"                => ":attribute deve ser um vetor.",
	"before"               => ":attribute deve ser uma data antes de :date.",
	"between"              => [
		"numeric" => ":attribute deve estar entre :min e :max.",
		"file"    => ":attribute deve ter entre :min e :max kilobytes.",
		"string"  => ":attribute deve ter entre :min e :max caracteres.",
		"array"   => ":attribute deve ter entre :min e :max itens.",
	],
	"boolean"              => "O campo :attribute deve ser true ou false.",
	"confirmed"            => "A confirmação do :attribute não fecha.",
	"date"                 => ":attribute não é uma data válida.",
	"date_format"          => ":attribute não contém o formato :format.",
	"different"            => ":attribute e :other devem ser diferentes.",
	"digits"               => ":attribute deve ser :digits dígitos.",
	"digits_between"       => ":attribute deve ter entre :min e :max dígitos.",
	"email"                => ":attribute deve ter um endereço de e-mail válido.",
	"filled"               => "O campo :attribute é requerido.",
	"exists"               => "O :attribute selecionado é inválido.",
	"image"                => ":attribute deve ser uma imagem.",
	"in"                   => "O :attribute selecionado é inválido.",
	"integer"              => ":attribute deve ser um inteiro.",
	"ip"                   => ":attribute deve ter um endereço IP válido.",
	"max"                  => [
		"numeric" => ":attribute não deve ser maior que :max.",
		"file"    => ":attribute não deve ser maior que :max kilobytes.",
		"string"  => ":attribute não pode ter mais de :max caracteres.",
		"array"   => ":attribute não pode ter mais de :max itens.",
	],
	"mimes"                => ":attribute deve ser um arquivo do tipo: :values.",
	"min"                  => [
		"numeric" => ":attribute deve ter ao menos :min.",
		"file"    => ":attribute deve ter ao menos :min kilobytes.",
		"string"  => ":attribute deve ter ao menos :min caracteres.",
		"array"   => ":attribute deve ter ao menos :min itens.",
	],
	"not_in"               => "O :attribute selecionado é inválido.",
	"numeric"              => ":attribute deve ser um número.",
	"regex"                => "O formato de :attribute é inválido.",
	"required"             => "Este campo é obrigatório.",
	"required_if"          => "O campo de :attribute é requerido quando :other é :value.",
	"required_with"        => "O campo de :attribute é requerido quando :values está presente.",
	"required_with_all"    => "O campo de :attribute é requerido quando :values está presente.",
	"required_without"     => "O campo de :attribute é requerido quando :values não está presente.",
	"required_without_all" => "O campo de :attribute é requerido quando nenhum de :values está presente.",
	"same"                 => "As senhas devem ser iguais.",
	"size"                 => [
		"numeric" => ":attribute deve ter :size.",
		"file"    => ":attribute deve ter :size kilobytes.",
		"string"  => ":attribute deve ter :size caracteres.",
		"array"   => ":attribute deve conter :size itens.",
	],
	"string"               => ":attribute deve ser string.",
	"unique"               => "Este valor já foi utilizado.",
	"url"                  => "O formato de :attribute é inválido.",
	"timezone"             => ":attribute deve dentro da zona válida.",

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
