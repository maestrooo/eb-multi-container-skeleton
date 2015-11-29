# Elastic Beanstalk

Elastic Beanstalk uses Docker to power its multi-container Docker platform type. This project is a boilerplate code for a multi-container Elastic
Beanstalk application.

This document contains a small documentation on how to create an Elastic Beanstalk multi-container environment.

## Installing AWS EB tools

The first thing is to install the EB tools (this assume that Brew has been installed):

* `brew install awsebcli`.
* Verify that it works by typing the `eb` command in the terminal.

## Specifying the AWS IAM user

In order to being able to use the AWS tools, you will need to specify the IAM you need to use, as 
[explained here](http://docs.aws.amazon.com/elasticbeanstalk/latest/dg/eb-cli3-configuration.html#eb-cli3-credentials).

## Creating the EB project

A typical Elastic Beanstalk project will look like this:

    .ebextensions/
      server.config
    .elasticbeanstalk/
    php-app/
      public/
        index.php
      src/
        ComponentA/
          ...
        ComponentB/
          ...
      vendor/
    proxy/
      conf.d/
        default.conf
    .gitignore
    .ebignore
    Dockerrun.aws.json

The `.ebextensions` folder is a special Elastic Beanstalk folder that allows to personnalize the underlying instances. Typically we will use this
to add server variables that can then be configured right into the Elastic Beanstalk environment.

The `.elasticbeanstalk` folder is a special Elastic Beanstalk folder that is not commited and contains some local config info.

The `php-app` folder will contain all the PHP code. It can be splitted into multiple modules.

The `proxy` folder contains the Nginx configuration.

The `.ebignore` is like a `.gitignore`, but is used by Elastic Beanstalk instead. For instance, you may want to add the `/vendor` folder into 
the `.gitignore`, but not into the `.ebignore`, so that it's part of the deployed ZIP.

Finally, the `Dockerrun.aws.json` file allows to configure the Docker configuration of the Elastic Beanstalk instance.

For instance, here is a simple `Dockerrun.aws.json` file that allows to create