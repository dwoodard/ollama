<?php

namespace Dwoodard\Ollama\Tests\Unit;

use Dwoodard\Ollama\Ollama;
use PHPUnit\Framework\TestCase;

class OllamaTest extends TestCase
{
    public function test_process_text()
    {
        $ollama = new Ollama('http://localhost:11434');
        $result = $ollama->processText('Invoice amount is $500 from John Doe');

        $this->assertArrayHasKey('total_amount', $result);
        $this->assertArrayHasKey('customer', $result);
    }
}
