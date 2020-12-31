//**
// Build Scripts + Dev Tools
//**

const fs = require("fs");
const { exec } = require("child_process");
const readline = require("readline-sync");
const imagemin = require('imagemin');
const imageminJpegtran = require('imagemin-jpegtran');
const imageminPngquant = require('imagemin-pngquant');
const imageminWebp = require('imagemin-webp');

const args = process.argv.slice(2);
const script = args[0];

const runCommand = (commandStr, callback, options) => {
    exec(commandStr, (error, stdout, stderr) => {
        if (error) {
            return logError(error.message);
        }
        if (stderr) {
            return logError(stderr);
        }
        if (typeof callback === 'function') {
            callback(stdout);
        }
        return stdout;
    });
}

const logError = errorMessage => {
    console.error(`❌ ${errorMessage}`);
};

//**
// Styles 
// Transpiles, prefixes, and minifies SCSS.
//**
const styles = (exit) => {
    // transpile SCSS into CSS
    runCommand('node-sass styles/ -o ./', () => {
        console.log('✅ SCSS => CSS');
        // add browser prefixes to CSS
        runCommand('postcss --use autoprefixer -b \'last 5 versions\' ./style.css -o ./style.css', () => {
            console.log('✅ CSS Autoprefixed');
            // minify CSS
            runCommand('node-sass ./style.css ./style.css --output-style compressed --source-map true', () => {
                console.log('✅ CSS Minified');
                if (exit) process.exit();
            });
        });
    });
};

//**
// Scripts
// Transpiles and minifies JS.
//**
const scripts = (exit) => {

    // loop through all JS files 
    fs.readdirSync('./js/src').forEach(file => {
        const newFile = file.replace('.js', '.min.js');

        // only attempt to process .js files 
        if (file.slice(file.length - 3) !== '.js') return;

        // transpile ES6 JS to ES2015 JS
        runCommand(`yarn babel ./js/src/${file} --out-file ./js/dist/${newFile} --source-maps`, () => {
            console.log('✅ JS Transpiled');

            // minify transpiled JS
            runCommand(`yarn uglifyjs ./js/dist/${newFile} --output ./js/dist/${newFile} --compress --source-map url=theme.min.js.map`, () => {
                console.log('✅ JS Minified');

                if (exit) process.exit();
            });

        });

    });

};

//**
// Images
// Optimizes JPG and PNG images for web, and generates WEBP formats for both.
//**
const images = async (exit) => {
    await imagemin(['images/src/*.{jpg,png}'], {
        destination: 'images/dist',
        plugins: [
            imageminJpegtran(),
			imageminPngquant({
				quality: [0.6, 0.8]
            }),
            imageminWebp({
                quality: 50
            })
        ]
    });
    console.log('✅ Images Optimized');
    if (exit) process.exit();
};

if (script === 'styles') {
    styles(true);
}

if (script === 'scripts') {
    scripts(true);
}

if (script === 'images') {
    images(true);
}

// to do: output info from running scripts i.e. browsersync url
if (script === 'watch') {
    console.log('watching CSS and JS files for changes...');
    runCommand('concurrently --kill-others "yarn watch:css" "yarn watch:js" "yarn browser-sync start -c bs-config.js"', () => {
        // watching...
    });
}

//**
// Slate Helper Functions (Experimental)
//**
const termGreen = '\x1b[32m';
const termReset = '\x1b[0m';
if (script === 'slate') {

    const subCommand = args[1];

    if (subCommand === 'addTemplate') {
        // get template information from user 
        const name = readline.question('Enter template name: ');
        const slug = readline.question('Enter template slug: ');

        // generate controller file contents
        let templateController = fs.readFileSync('./resources/new-template.php');
            templateController = templateController
                .toString()
                .replace('__SLUG__', slug)
                .replace('__NAME__', name);
                
        // generate view file contents
        const templateView = fs.readFileSync('./resources/new-template.twig').toString();

        // create files
        fs.writeFileSync(`template-${slug}.php`, templateController);
        fs.writeFileSync(`views/templates/page-${slug}.twig`, templateView);

        // output results
        console.log(termGreen);
        console.log(`template-${slug}.php generated.`);
        console.log(`views/templates/page-${slug}.twig generated.`);
        console.log(termReset);

        // open new files in VS Code
        runCommand(`code template-${slug}.php`);
        runCommand(`code views/templates/page-${slug}.twig`);
    }

}