const bootstrapSassAbstractsImports = require('vue-cli-plugin-bootstrap-vue/sassAbstractsImports.js');
const path = require('path');

module.exports = {
  configureWebpack: {
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'src'),
      },
    },
  },
  css: {
    loaderOptions: {
      sass: {
        additionalData: bootstrapSassAbstractsImports.join('\n'),
      },
      scss: {
        additionalData: [...bootstrapSassAbstractsImports, ''].join(';\n'),
      },
    },
  },
};
