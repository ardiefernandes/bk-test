<?php

declare(strict_types=1);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12'                                      => true,
        'no_unused_imports'                           => true,
        'no_unneeded_import_alias'                    => true,
        'array_indentation'                           => true,
        'declare_strict_types'                        => true,
        'combine_consecutive_unsets'                  => true,
        'multiline_whitespace_before_semicolons'      => false,
        'single_quote'                                => true,
        'trailing_comma_in_multiline'                 => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_spaces_around_offset'                     => true,
        'no_whitespace_before_comma_in_array'         => true,
        'object_operator_without_whitespace'          => true,
        'trim_array_spaces'                           => true,
        'unary_operator_spaces'                       => true,
        'whitespace_after_comma_in_array'             => true,
        'space_after_semicolon'                       => true,
        'blank_line_before_statement'                 => true,
        'blank_line_after_namespace'                  => true,
        'function_typehint_space'                     => true,
        'include'                                     => true,

        'array_syntax'                => ['syntax' => 'short'],
        'concat_space'                => ['spacing' => 'one'],
        'single_line_comment_style'   => ['comment_types' => ['hash']],
        'class_attributes_separation' => ['elements' => ['method' => 'one']],
        'braces'                      => ['position_after_anonymous_constructs' => 'next'],

        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'align',
                '='  => 'align',
                '+=' => 'align',
                '.=' => 'align',
                '-=' => 'align',
            ],
        ],
        'no_extra_blank_lines' => [
            'tokens' => [
                'curly_brace_block',
                'extra',
                // 'parenthesis_brace_block',
                // 'square_brace_block',
                'throw',
                'use',
            ],
        ],

    ])
    // ->setIndent("\t")
    ->setLineEnding("\n")
;
