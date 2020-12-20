//##
// Build Scripts + Dev Tools
// ##

const { exec } = require("child_process");

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

const styles = () => {
    // transpile SCSS into CSS
    runCommand('node-sass sass/ -o ./', () => {
        console.log('✅ SCSS => CSS');
        // add browser prefixes to CSS
        runCommand('postcss --use autoprefixer -b \'last 5 versions\' ./style.css -o ./style.css', () => {
            console.log('✅ CSS Autoprefixed');
            // minify CSS
            runCommand('node-sass ./style.css ./style.css --output-style compressed --source-map true', () => {
                console.log('✅ CSS Minified');
            });
        });
    });
};

const scripts = () => {
    // transpile ES6 JS to ES2015 JS
    runCommand('yarn babel ./js/theme.js --out-file ./js/theme.min.js --source-maps', () => {
        console.log('✅ JS Transpiled');
        // minify JS
        runCommand('yarn uglifyjs ./js/theme.min.js --output ./js/theme.min.js --compress --source-map url=theme.min.js.map', () => {
            console.log('✅ JS Minified');
        });
    });
};

const images = () => {
    runCommand('imageoptim \'/images\'', () => {
        console.log('✅ Images Optimized');
    });
};

if (script === 'styles') {
    styles();
}

if (script === 'scripts') {
    scripts();
}

if (script === 'images') {
    images();
}


if (script === 'watch') {
    var twirlTimer = (function() {
        var P = ["\\", "|", "/", "-"];
        var x = 0;
        return setInterval(function() {
          process.stdout.write("\r" + P[x++]);
          x &= 3;
        }, 250);
    })();
    runCommand('concurrently --kill-others "yarn watch:css" "yarn watch:js"', () => {
        // watching...
    });
}