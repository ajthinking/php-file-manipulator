<?php

class TraitTest extends Archetype\Tests\TestCase
{
    /** @test */
    public function it_can_test()
    {
        $this->assertEquals(
            PHPFile::load('app/Models/User.php')->trait(),
            ['HasFactory', 'Notifiable']
        );
    }
}
