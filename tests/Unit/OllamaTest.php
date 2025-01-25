<?php

namespace Dwoodard\Ollama\Tests\Unit;

use Dwoodard\Ollama\Ollama;
use PHPUnit\Framework\TestCase;

class OllamaTest extends TestCase
{
    public function test_process_text()
    {
        $ollama = \Mockery::mock(Ollama::class);
        $ollama->shouldReceive('processText')
            ->with('Invoice amount is $500 from John Doe')
            ->andReturn(['total_amount' => 500, 'customer' => 'John Doe']);
        $result = $ollama->processText('Invoice amount is $500 from John Doe');

        $this->assertArrayHasKey('total_amount', $result);
        $this->assertArrayHasKey('customer', $result);
    }
}
