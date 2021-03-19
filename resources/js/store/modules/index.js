const requireModule = require.context('.', false, /^((?!\.spec\.).)*\.js$/);
const modules = {};

requireModule.keys().forEach(filename => {
  if (filename === './index.js') return;

  const moduleName = filename
      .replace(/(\.\/|\.store\.js)/g, '')
      .replace(/(\.\/|\.js)/g, '');

  modules[moduleName] = requireModule(filename).default || requireModule(filename);
});

export default modules;

