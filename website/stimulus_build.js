const esbuild = require("esbuild");

esbuild.build({
    entryPoints: ["stimulus/index.js"],
    bundle: true,
    outfile: "public/js/stimulus.js",
    platform: "browser",
    sourcemap: true,
    target: ["es2020"],
    format: "esm",
}).catch(() => process.exit(1));
