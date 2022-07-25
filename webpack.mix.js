const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix

    /**
     * js
     */
    // js global
    .scripts([
        "node_modules/bootstrap/dist/js/bootstrap.bundle.js"
    ], "public/assets/js/boostrap.min.js")
    .scripts([
        "node_modules/jquery/dist/jquery.js",
        "node_modules/jquery-ui-dist/jquery-ui.js"
    ], "public/assets/js/jquery.min.js")
    .scripts(["node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"], "public/assets/js/jquery-mask.min.js")
    .scripts(['resources/js/plugins/form-submit.js', 'resources/js/scripts.js'], 'public/assets/js/scripts.min.js')

    // js admin
    .scripts(["resources/js/admin/scripts.js"], "public/assets/js/admin/scripts.js")

    // js member
    .scripts(["resources/js/member/scripts.js"], "public/assets/js/member/scripts.js")

    // js front
    .scripts(["resources/js/front/scripts.js"], "public/assets/js/front/scripts.js")

    // js auth
    .scripts(["resources/js/auth/scripts.js"], "public/assets/js/auth/scripts.js")

    /**
     * SASS
     */

    // sass global

    // sass admin
    .sass("resources/scss/admin/styles.scss", "public/assets/css/admin/styles.css")

    // sass member
    .sass("resources/scss/member/styles.scss", "public/assets/css/member/styles.css")

    // sass front
    .sass("resources/scss/front/styles.scss", "public/assets/css/front/styles.css")

    // sass auth
    .sass("resources/scss/auth/styles.scss", "public/assets/css/auth/styles.css")

    /**
     * CSS
     */
    .css("node_modules/boxicons/css/boxicons.css", "public/assets/css/boxicons.min.css")
    .css("node_modules/bootstrap-icons/font/bootstrap-icons.css", "public/assets/css/bootstrap-icons.min.css");


    // js("resources/js/app.js", "public/js")
    // .postCss("resources/css/app.css", "public/css", []);
