<?php
namespace Tests\Provider;

use Prometheus\Storage\Adapter;
use Tests\TestCase;
use Triadev\PrometheusExporter\Provider\PrometheusExporterServiceProvider;

class PredisAdapterTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        $app['config']->set('prometheus-exporter.adapter', 'predis');
        
        return [
            PrometheusExporterServiceProvider::class
        ];
    }
    
    /**
     * @test
     */
    public function it_checks_the_concrete_implementation_of_prometheus_adapter()
    {
        $this->assertEquals('Predis', class_basename(app(Adapter::class)));
    }
}