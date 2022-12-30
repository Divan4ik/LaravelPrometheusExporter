<?php

namespace Triadev\PrometheusExporter\Collector;


use Triadev\PrometheusExporter\Contract\PrometheusExporterContract;

class FpmCollector
{

    public function collect()
    {
        if (!function_exists('fpm_get_status')) {
            return;
        }

        $fpmStatus = fpm_get_status();
        $registry = app(PrometheusExporterContract::class);
        $metrics_namespace = config('prometheus-exporter.fpm_metrics_namespace');

        $registry->setGauge('start_time', 'start_time', $fpmStatus['start-time'], $metrics_namespace);
        $registry->setGauge('accepted_conn', 'accepted_conn', $fpmStatus['accepted-conn'], $metrics_namespace);
        $registry->setGauge('listqueue', 'listen_queue', $fpmStatus['listen-queue'], $metrics_namespace);
        $registry->setGauge('max_listen_queue', 'max_listen_queue', $fpmStatus['max-listen-queue'], $metrics_namespace);
        $registry->setGauge('listen_queue_len', 'listen_queue_len', $fpmStatus['listen-queue-len'], $metrics_namespace);
        $registry->setGauge('idle_processes', 'idle_processes', $fpmStatus['idle-processes'], $metrics_namespace);
        $registry->setGauge('active_processes', 'active_processes', $fpmStatus['active-processes'], $metrics_namespace);
        $registry->setGauge('max_active_processes', 'max_active_processes', $fpmStatus['max-active-processes'], $metrics_namespace);
        $registry->setGauge('max_children_reached', 'max_children_reached', $fpmStatus['max-children-reached'], $metrics_namespace);
        $registry->setGauge('slow_requests', 'slow_requests', $fpmStatus['slow-requests'], $metrics_namespace);

        foreach ($fpmStatus['procs'] as $proc) {
            $registry->setGauge('proc_start_time', 'proc start time', $proc['start-time'], $metrics_namespace, ['pid'], [$proc['pid']]);
            $registry->setGauge('proc_requests', 'proc requests', $proc['requests'], $metrics_namespace, ['pid'], [$proc['pid']]);
        }
    }
}