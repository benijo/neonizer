# Neonizer

Bundle of symfony/console commands to manage your config files.

## Usage

### Stand-alone use

You can call `vendor/bin/neonizer <command>` directly.

### Nette Extension

You will need some Symfony/Console implementation - take a look at [Contributte/Console](https://github.com/contributte/console).

Then register extensions.

```yaml

extensions:
    console: Contributte\Console\DI\ConsoleExtension
    neonizer: Contributte\Neonizer\DI\NeonizerExtension
```

Now you can find `neonizer` section in you console.

Just type `bin/console neonzier:<command>`. 

### Composer Plugin

[TODO](#)

## Commands

### Process 

Use template/dist-file config to create your local/production config. 

[TODO](#)

### Validate

Validate config file.

[TODO](#)

### Get

Get config file section.

[TODO](#)

### Set

Set config file section.

[TODO](#)
