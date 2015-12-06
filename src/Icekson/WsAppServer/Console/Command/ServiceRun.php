<?php
/**
 * @author a.itsekson
 * @created 01.11.2015 18:16
 */

namespace Icekson\WsAppServer\Console\Command;

use Icekson\WsAppServer\Application;
use Icekson\WsAppServer\Config\ApplicationConfig;
use Icekson\WsAppServer\Config\ServiceConfig;
use Icekson\WsAppServer\Exception\ServiceException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ServiceRun extends BaseCommand
{

    protected function configure()
    {
        $this
            ->setName('app:service')
            ->setDescription('Start application service')
            ->addOption(
                'type',
                null,
                InputOption::VALUE_REQUIRED,
                'Type of service',
                null
            )
            ->addOption(
                'routing-key',
                null,
                InputOption::VALUE_REQUIRED,
                'Routing key for jobs service',
                "#"
            )
            ->addOption(
                'name',
                null,
                InputOption::VALUE_REQUIRED,
                'Name of service',
                null
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = time();
        $this->logger()->debug("Start [" . gmdate("Y-m-d H:i:s") . ']');
        $this->logger()->debug("arguments : " . var_export($input->getArguments(), true));
        $this->logger()->debug("options : " . var_export($input->getOptions(), true));
        $name = $input->getOption('name');
        $type = $input->getOption('type');
        $routingKey = $input->getOption('routing-key');
        $configPath = PATH_ROOT . "config/server.json";
        $appConf = new ApplicationConfig($configPath);

        $app = new Application($appConf);
        $app->runService($name, $type, $routingKey);

        $executionTime = gmdate("H:i:s", time() - $start);
        $this->logger()->debug("Finish [" . gmdate("Y-m-d H:i:s") . ']');
        $this->logger()->debug("Execution Time $executionTime [H:i:s]");


    }

} 