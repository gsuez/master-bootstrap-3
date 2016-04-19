# Integrated Gulp build system.

## Index

1. [What is Gulp?](#what-is-gulp)
2. [How can Gulp improve my workflow?](#how-gulp-helps)
3. [Glosary.](#glosary)
4. [The Gulp workflow.](#the-gulp-workflow)
5. [Setting up Gulp.](#setting-up-gulp)
6. [Available Gulp tasks.](#available-gulp-tasks)
7. [Gulp resources.](#resources)


## <a name="what-is-gulp"></a>1. What is Gulp?

This templates includes an integrated [Gulp](http://gulpjs.com/) build system ready for you. 

Gulp is a fast and intuitive build tool built on Node.js. If you are familiar with [Grunt](http://gruntjs.com/) the concept is the same but in Grunt you use a large configuration file while in Gulp you use small tasks that can be concatenated using streams. Gulp is 4x times faster than Grunt. See [resources](#resources) for more information.

## <a name="how-gulp-helps"></a>2. How can Gulp improve my workflow?

If you are using this template it probably means that you are used to edit css/js files & click refresh in your browser to see the changes you have done in action. Gulp is here to save you time.

Gulp magic:

* Compiles automatically the [Sass](http://sass-lang.com/) files you have modified compiles them and refresh the browser for you so you see changes in real time!
* Allows you to debug any connected device remotely. So you can see how the current page is shown in multiple devices at the same time.
* Copy any modified files from your repository folder to the working website folder. That includes language strings, php files, assets... 
* Watch `template.js` and compile it when modified to `template.min.js` to both repository folder and working website
* When a file is modified Browsersync is automatically reloaded so you get your changes refreshed directly in your web browser.
* Create a zip installer for your template with 1 single command.

"Sass? I don't have time to learn that." You don't need to understand its complexity to start using sass files as you have been using css. Same markup works.

## <a name="glosary"></a>3. Glosary
* `Working website`: Joomla website where you are integrating Master Bootstrap template
* `Repository folder`: Folder where your clone of Master Bootstrap resides. 

## <a name="the-gulp-workflow"></a>4. The Gulp workflow

The workflow intended to be used by this template with Gulp is:

1. You have a working website (you are integrating or testing `master-bootstrap-3` on a joomla website)
2. Instead of having to symblink or copy/reinstall files when you modify them you will work always on the `master-bootstrap-3` repository folder.
3. Initially you use `Install from folder` Joomla feature to install the template from the repository folder. You can also run discover install if you have already copied the files to the working website
4. Then in your repository folder run `gulp` and the Gulp system will copy files, start watching for changes and updating automatically the website and refresh the browser,

## <a name="setting-up-gulp"></a>5. Setting up Gulp
1. Install Node.js using the method that applies to your OS. Check https://nodejs.org/
2. Enter in your repository folder and install all the Node.js dependencies with: `npm install`
3. Duplicate `gulp-config.dist.json` to `gulp-config.json` and change the settings there to adjust them to your local system:
    * `wwwDir`: folder where your joomla website is. It will be used to copy files there when modified
    * `browserConfig`: BrowserSync settings if you want to modify them. Check https://www.browsersync.io/docs/options/
4. Run `gulp` to start the Gulp system. Gulp will keep running to detect any modification done to the files and execute the required task associated to that file. Stop it when you stop working on the project.

## <a name="available-gulp-tasks"></a>6. Available Gulp tasks

You can run any task listed here from terminal.

* `gulp clean`: Cleans all the template files from the working website.
* `gulp copy`: Copies template files to the working website.
* `gulp watch`: Starts watching for changes in the repository folder to compile them and update the working website and local files.
* `gulp sass`: Compile Sass files in the repository folder and copy them to the local `css` folder + working website `css` folder
* `gulp scripts`: Compile `template.js` from the repository folder and copy results to the local `js` folder + working website `js` folder
* `gulp release`: Create an installable zip file in the `releases` folder so it can be installed on a joomla website.
* `gulp`. When running gulp with no tasks it will run the default task. That automatically launches: `copy`, `watch`, `browser-sync`. So it will copy all the files to the working website, start watching for changes there and launch an instance of BrowserSync in your browser that will be automatically refreshed when any change is done to the template files.

## <a name="resources"></a>7. Gulp resources

* [Gulp website](http://gulpjs.com/)
* [Gulp documentation](https://github.com/gulpjs/gulp/tree/master/docs)
* [Gulp vs Grunt](http://sixrevisions.com/web-development/grunt-vs-gulp/)
* [Browsersync](https://www.browsersync.io/)