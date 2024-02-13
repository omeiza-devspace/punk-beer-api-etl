module.exports = {
    testRegex: 'resources/js/.*.spec.js$',
    moduleFileExtensions: ['js', 'json', 'vue'],
    transform: {
      '^.+\\.vue$': 'vue-jest',
      '^.+\\.js$': 'babel-jest',
    },
    moduleNameMapper: {
      '^@/(.*)$': '<rootDir>/resources/js/$1',
    },
    setupFilesAfterEnv: ['<rootDir>/resources/js/tests/setup.js'],
    collectCoverageFrom: [
      '<rootDir>/resources/js/**/*.{js,jsx,ts,tsx,vue}',
      '!<rootDir>/resources/js/main.js',
      '!<rootDir>/resources/js/router/index.js',
      '!<rootDir>/resources/js/store/index.js',
    ],
    coverageDirectory: '<rootDir>/resources/js/tests/unit/coverage',
  };
  