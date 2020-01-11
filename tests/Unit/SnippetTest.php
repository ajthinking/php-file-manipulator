<?php

namespace Ajthinking\PHPFileManipulator\Tests\Unit;

use Ajthinking\PHPFileManipulator\Tests\TestCase;
use PhpParser\Node\Stmt\ClassMethod;


use Ajthinking\PHPFileManipulator\Support\Snippet;

class SnippetTest extends TestCase
{
    /** @test */
    public function it_can_load_class_methods_from_snippet_defaults()
    {
        $this->assertInstanceOf(
            ClassMethod::class,
            Snippet::___HAS_MANY_METHOD___()
        );            
    }

    /** @test */
    public function it_can_replace_snippet_names()
    {
        $method = Snippet::___HAS_MANY_METHOD___([
            '___HAS_MANY_METHOD___' => 'guitars'
        ]);

        $this->assertEquals(
            $this->laravelUserFile()->addClassMethods([$method])->classMethodNames(),
            ['cars', 'guitars']
        );            
    }    
    
    /** @test */
    public function it_cant_load_non_existing_snippets_from_defaults()
    {
        $this->assertNull(
            Snippet::NoSUchSnippet()
        );            
    }   
}
