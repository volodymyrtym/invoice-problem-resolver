const esbuild = require("esbuild");
const args = process.argv.slice(2);

const watch = args.includes("--watch");

const buildOptions = {
    entryPoints: ["stimulus/index.js"],
    bundle: true,
    outfile: "public/js/stimulus.js",
    platform: "browser",
    sourcemap: true,
    target: ["es2020"],
    format: "esm",
};

if (watch) {
    esbuild.context(buildOptions).then((ctx) => {
        ctx.watch();
        console.log("Watching for changes...");
    }).catch(() => process.exit(1));
} else {
    esbuild.build(buildOptions).then(() => {
        console.log("Build completed.");
    }).catch(() => process.exit(1));
}
