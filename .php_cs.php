<?php



use Ergebnis\PhpCsFixer\Config;


$json_path = __DIR__ . '/composer.json';
$composerinfo = \json_decode(\file_get_contents($json_path));

require_once __DIR__ . '/vendor/autoload.php';
$version = $composerinfo->extra->version;
$header = "JPGraph - Community Edition";

$config = Config\Factory::fromRuleSet(new Config\RuleSet\Php73($header), [
	'declare_strict_types' => false,
	'void_return' => false,
	'static_lambda' => false,
	'escape_implicit_backslashes' => false,
	'final_class' => false,
	'final_internal_class' => false,
	'final_public_method_for_abstract_class' => false,
	'final_static_access' => false,
	'global_namespace_import' => false,
	'fully_qualified_strict_types' => false,
	'visibility_required' => [
		'elements' => [
			'method',
			'property',
		],
	],
]);
$project_path = getcwd();
$config->getFinder()
	->in([
		__DIR__
	])
	->name('*.php')
	->exclude([
		'.build',
		'.configs',
		'__pycache__',
		'.git',
		'node_modules',
		'vendor',
		'.github',
	])
	->name('.php_cs.php')
	->ignoreDotFiles(true)
	->ignoreVCS(true);

$config->setCacheFile(__DIR__ . '/.build/csfixer.cache');

return $config;
