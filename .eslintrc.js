// https://eslint.org/docs/user-guide/configuring

module.exports = {
  extends: [
    // add more generic rulesets here, such as:
    '@vue/standard',
    // 'eslint:recommended',
    'plugin:vue/recommended'
  ],
  rules: {
    // override/add rules settings here, such as:
    // 'vue/no-unused-vars': 'error'
    'vue/max-attributes-per-line': 'off'
  },
  env: {
    "amd": true
  },
  parserOptions: {
    parser: 'babel-eslint'
  }
}
