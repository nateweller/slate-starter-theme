//**
// Build Scripts + Dev Tools
//**

const fs = require("fs");
const { exec } = require("child_process");
const readline = require("readline-sync");
const imagemin = require('imagemin-keep-folder');
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
    // Create optimized JPG or PNG
    await imagemin(['images/src/**/*.{jpg,png}'], {
        replaceOutputDir: output => {
            return output.replace('images/src', 'images/dist')
        },
        use: [
            imageminJpegtran(),
			imageminPngquant({
				quality: [0.6, 0.8]
            })
        ]
    });
    // Generate webp alternative
    await imagemin(['images/src/**/*.{jpg,png}'], {
        replaceOutputDir: output => {
            return output.replace('images/src', 'images/dist')
        },
        use: [
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
    runCommand('concurrently --kill-others "yarn watch:styles" "yarn watch:scripts" "yarn browser-sync start -c bs-config.js"', () => {
        // watching...
    });
}

//**
// Slate Helper Functions (Experimental)
//**
const termCyan = '\x1b[36m';
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

	if (subCommand === 'addAcfBlock') {
		console.log(termCyan);
		console.log('/**');
		console.log(' * Enter new block details below...');
		console.log(' * @link https://www.advancedcustomfields.com/resources/acf_register_block_type/');
		console.log(' */');
		console.log(termReset);
		// get block information from user
		const name = readline.question('Name: ');
		const slug = readline.question('Slug: ');
		const description = readline.question('Description: ');
		const category = readline.question('Category (common, formatting, layout, widgets, or embed): ');
		const icon = readline.question('Icon: ');
		const keywords = readline.question('Enter keywords i.e. foo,bar,baz: ');

		console.log('Mode');
		console.log(`(String) (Optional) The display mode for your block. Available settings are "auto", "preview" and "edit". Defaults to "preview".
auto: Preview is shown by default but changes to edit form when block is selected.
preview: Preview is always shown. Edit form appears in sidebar when block is selected.
edit: Edit form is always shown.

Note. When in “preview” or “edit” modes, an icon will appear in the block toolbar to toggle between modes.`);
		const mode = readline.question('Mode (auto, preview, or edit): ');
		const supports = readline.question('Supports i.e align,mode,jsx: ');

		// append block registration into ./inc/acf-blocks.php
		fs.appendFileSync('inc/acf-blocks.php', `
/**
 * ${name} ACF Block
 */
acf_register_block_type( array(
	'name' => __( '${name}' , '_slate' ),
	'slug' => '${slug}',
	'description' => __( '${description}', '_slate' ),
	'category' => '${category}',
	'icon' => '${icon}',
	'keywords' => array( '${keywords.split(',')}' ),
	'mode' => '${mode}',
	'supports' => '${supports}'
) );
		`);

		 // generate controller file contents
		 let blockController = fs.readFileSync('./resources/new-block.php');
		 blockController = blockController
			 .toString()
			 .replace('__NAME__', name);

		// generate view file contents
		const blockView = fs.readFileSync('./resources/new-block.twig').toString();

		// create files
		fs.writeFileSync(`blocks/acf-${slug}.php`, blockController);
		fs.writeFileSync(`views/components/${slug}.twig`, blockView);

		// output results
        console.log(termGreen);
        console.log(`blocks/acf-${slug}.php generated.`);
        console.log(`views/components/${slug}.twig generated.`);
        console.log(termReset);

        // open new files in VS Code
        runCommand(`code blocks/acf-${slug}.php`);
        runCommand(`code views/components/${slug}.twig`);

	}

}
