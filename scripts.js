//**
// Build Scripts + Dev Tools
//**

const fs = require("fs");
const { exec } = require("child_process");
const readline = require("readline-sync");

const args = process.argv.slice(2);
const script = args[0];

const runCommand = (commandStr, callback) => {
    exec(commandStr, (error, stdout, stderr) => {
        if (error) {
            return logError(error.message);
        }
        if (stderr) {
            return logError(stderr);
        }
        if (typeof callback === 'function') {
            callback();
        }
    });
}

const logError = errorMessage => {
    console.error(`❌ ${errorMessage}`);
};

//**
// Styles 
// Transpiles, prefixes, and minifies SCSS in ./sass into CSS in ./
//**
const styles = (exit) => {
    // transpile SCSS into CSS
    runCommand('node-sass sass/ -o ./', () => {
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
// Transpiles and minifies all JS files from ./js/src into ./js/dist
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

const images = (exit) => {
    runCommand('imageoptim \'/images\'', () => {
        console.log('✅ Images Optimized');
        if (exit) process.exit();
    });
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

if (script === 'watch') {
    console.log('watching CSS and JS files for changes...');
    runCommand('concurrently --kill-others "yarn watch:css" "yarn watch:js"', () => {
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

        console.log(termGreen);
        console.log(`template-${slug}.php generated.`);
        console.log(`views/templates/page-${slug}.twig generated.`);
        console.log(termReset);

        runCommand(`code template-${slug}.php`);
        runCommand(`code views/templates/page-${slug}.twig`);
    }

}