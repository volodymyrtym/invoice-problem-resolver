const esbuild = require("esbuild");
const sassPlugin = require("esbuild-plugin-sass");
const fs = require("fs");
const path = require("path");
const crypto = require("crypto");

const isProd = process.env.NODE_ENV === "prod";
const outdir = "public/build";

const buildOptions = {
    entryPoints: {
        "js/stimulus-app": "templates/stimulus-app.js",
        "css/login": "templates/login/login.scss",
        "css/daily-activities": "templates/daily-activities/daily-activities.scss"
    },
    outdir: outdir,
    bundle: true,
    minify: isProd,
    sourcemap: !isProd,
    plugins: [
        sassPlugin(),
    ],
    loader: {
        ".js": "jsx",
        ".scss": "css"
    },
    write: false, // Do not write files directly, we'll process them
};

// Function to clean up the output directory
function cleanBuildDirectory(directory) {
    if (fs.existsSync(directory)) {
        fs.readdirSync(directory).forEach((file) => {
            if (file === ".gitkeep") {
                return; // Skip .gitkeep
            }
            const filePath = path.join(directory, file);
            if (fs.lstatSync(filePath).isDirectory()) {
                cleanBuildDirectory(filePath);
                fs.rmdirSync(filePath);
            } else {
                fs.unlinkSync(filePath);
            }
        });
        console.log(`Cleaned: ${directory}`);
    }
}

// Function to handle build results, generate hashes, and update manifest.json
function handleBuildResult(result) {
    const manifest = {};

    for (const outputFile of result.outputFiles) {
        const relativePath = path.relative(outdir, outputFile.path); // Get relative path
        const ext = path.extname(relativePath);
        const baseName = path.basename(relativePath, ext);

        // Determine subdirectory (e.g., `js/` or `css/`)
        const subDir = path.dirname(relativePath);
        const outputDir = path.join(outdir, subDir);

        // Create subdirectory if it doesn't exist
        if (!fs.existsSync(outputDir)) {
            fs.mkdirSync(outputDir, {recursive: true});
        }

        // Generate hash
        const hash = crypto.createHash("md5").update(outputFile.contents).digest("hex").slice(0, 8);
        const hashedName = `${baseName}.${hash}${ext}`;
        const hashedPath = path.join(outputDir, hashedName);

        // Write original file
        const originalPath = path.join(outputDir, path.basename(outputFile.path));
        fs.writeFileSync(originalPath, outputFile.contents);

        // Write hashed file
        fs.writeFileSync(hashedPath, outputFile.contents);

        // Add to manifest with `/build/` prefix
        manifest[`/build/${path.join(subDir, path.basename(outputFile.path))}`] =
            `/build/${path.join(subDir, hashedName)}`;
    }

    // Write manifest.json
    fs.writeFileSync(path.join(outdir, "manifest.json"), JSON.stringify(manifest, null, 2));

    console.log("Manifest, original, and hashed files updated.");
}

// Main function for build and watch modes
async function buildAndWatch() {
    cleanBuildDirectory(outdir); // Clean output directory before building

    esbuild
        .build(buildOptions)
        .then((result) => {
            handleBuildResult(result); // Process results after build
            console.log("Build completed!");
        })
        .catch(() => process.exit(1));

}

// Start the build process
buildAndWatch();
