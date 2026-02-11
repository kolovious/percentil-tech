module.exports = {
  testEnvironment: 'jsdom',
  moduleFileExtensions: ['js', 'json', 'vue'],
  transform: {
    '^.+\\.vue$': 'vue-jest',
    '^.+\\.js$': 'babel-jest'
  },
  moduleNameMapper: {
    '\\.(css|scss)$': '<rootDir>/tests/js/styleMock.js'
  },
  testMatch: ['**/__tests__/**/*.spec.js'],
  collectCoverageFrom: [
    'assets/js/components/**/*.vue'
  ]
};
