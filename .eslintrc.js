// module.exports = {
//   root: true,
//   parser: 'babel-eslint',
//   env: {
//     browser: true,
//     node: true
//   },
//   // extends: 'standard',
//   // required to lint *.vue files
//   plugins: [
//     'html'
//   ],
//   // add your custom rules here
//   rules: {},
//   globals: {}
// }

module.exports = {
    root: true,
    parserOptions: {
        parser: 'babel-eslint',
        ecmaVersion: 6
    },
    plugins: ['vue'],
    env: {
        browser: true,
        node: true
    },
    // extends: [
    //     "standard",
    //     "plugin:vue/recommended"
    // ],
    extends: ['plugin:vue/essential', 'standard'],
    // 'extends': [
    // 'plugin:vue/strongly-recommended', // strongly-recommended
    // 'standard',
    // '@vue/standard'
    // ],
    // 'plugins': [
    //   'vue'
    // ],
    // "overrides": [
    //   {
    //     "files": ["*.js", "*.vue"],
    //   }
    // ],
    rules: {
        'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',

        'no-multiple-empty-lines': 'off'
    }
}

