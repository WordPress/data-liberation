# Starter WordPress Plugin ReactJS

A ready-to-use WordPress Plugin makes it easy to integrate React JS into the development of a WordPress Plugin.

you can create your JSX components and turn them into Javascript which will be enqueue by WordPress.

  

## Requirements

  

Install the module bundler Webpack v4+ , webpack-cli ***globally***.

```

npm install -g webpack

npm install -g webpack-cli

```

  

## Installation

1. Clone the repository to the Plugins directory of your WordPress installation: ` / wp-content / plugins / ` .

  

2. Install the dependencies :

```

$ npm install

```

3. run webpack :

```

$ webpack

```

**and that's all!** :+1: you will have a new directory at the root of your plugin: `dist` which contains the compiled javascript file.

now you can create your JSX components, and when you're ready, rerun ``` $ webpack```.

  

## View

  

The Plugin create a menu entry in ` Tools->WP Plugin React ` , visit this page to see the result.
![](https://raw.githubusercontent.com/younes-dro/assets/a4636d6b87658d5e732f462f32e864a7d28ee631/dro-wp-plugin-js.png)
## Troubleshooting

  

### Script Execution Policy Error in PowerShell

  

If you encounter an error related to the script execution policy when running `webpack` in PowerShell, you may need to adjust the execution policy. This error typically looks like:

  

```plaintext

webpack: Unable to load the file C:\Users\YourUsername\AppData\Roaming\npm\webpack.ps1 because

script execution is disabled on this system.

  

Solution:

1. Open PowerShell as an administrator.

2. Run the following command to set the execution policy for the current user:

  

```powershell

Set-ExecutionPolicy -Scope CurrentUser -ExecutionPolicy RemoteSigned