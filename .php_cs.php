<?php

$composerinfo          = json_decode(file_get_contents('composer.json'));
$version = $composerinfo->version;

$header = "JPGraph v$version";



$config = PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        'no_php4_constructor'=>true,
        '@PHP56Migration' => true,
        '@PHPUnit60Migration:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => false,
        '@PSR1'=>true,
        '@PSR2'=>true,
        'align_multiline_comment' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_before_statement' => true,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'compact_nullable_typehint' => true,
        'escape_implicit_backslashes' => true,
        'explicit_indirect_variable' => true,
        'no_whitespace_in_blank_line'=> true,
        'no_unused_imports'=>true,
        'concat_space'=> ['spacing'=>'one'],
        'elseif'=>true,
        'explicit_string_variable' => true,
        'final_internal_class' => true,
        'modernize_types_casting'=>true,
        'header_comment' => ['commentType'=>'PHPDoc','header' => $header],
        'heredoc_to_nowdoc' => true,
        'phpdoc_no_package' => false,
        'list_syntax' => ['syntax' => 'long'],
        'method_chaining_indentation' => true,
        'method_argument_space' => ['ensure_fully_multiline' => true],
        'multiline_comment_opening_closing' => true,
        'no_extra_blank_lines' => ['tokens' => ['break', 'continue', 'extra', 'return', 'throw', 'use', 'parenthesis_brace_block', 'square_brace_block', 'curly_brace_block']],
        'no_null_property_initialization' => true,
        'no_short_echo_tag' => true,
        'no_superfluous_elseif' => true,
        'no_unneeded_curly_braces' => true,
        'no_unneeded_final_method' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => false,
        'ordered_imports' => true,
        'php_unit_strict' => true,
        'php_unit_test_annotation' => true,
        'php_unit_test_class_requires_covers' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_align'=>true,
        'phpdoc_order' => true,
        'phpdoc_separation'=>true,
        'phpdoc_scalar'=>true,
        'phpdoc_trim'=>true,
        'phpdoc_types_order' => true,
        'semicolon_after_instruction' => true,
        'single_line_comment_style' => false,
        'strict_comparison' => false,
        'strict_param' => true,
        'single_quote'=>true,
        'yoda_style' => false,
        'binary_operator_spaces' => [
            'align_double_arrow' => true,
            'align_equals' => true
        ]

    ])
    ->setFinder(
         PhpCsFixer\Finder::create()
            ->in(__DIR__.'/Examples')
            ->in(__DIR__.'/src')
            ->files()->name('*.php')
            ->notName('GB2312toUTF8.php')
    );

// special handling of fabbot.io service if it's using too old PHP CS Fixer version
try {
    PhpCsFixer\FixerFactory::create()
        ->registerBuiltInFixers()
        ->registerCustomFixers($config->getCustomFixers())
        ->useRuleSet(new PhpCsFixer\RuleSet($config->getRules()));
} catch (PhpCsFixer\ConfigurationException\InvalidConfigurationException $e) {
    $config->setRules([]);
} catch (UnexpectedValueException $e) {
    $config->setRules([]);
} catch (InvalidArgumentException $e) {
    $config->setRules([]);
}        
        
return $config;
