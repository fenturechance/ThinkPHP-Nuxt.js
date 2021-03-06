
export default {
  mode: 'universal',
  /*
  ** Headers of the page
  */
  head: {
    title: process.env.npm_package_name || '',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: process.env.npm_package_description || '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },
  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#fff' },
  /*
  ** Global CSS
  */
  css: [
    'element-ui/lib/theme-chalk/index.css'
  ],
  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    '@/plugins/element-ui'
  ],
  /*
  ** Nuxt.js dev-modules
  */
  devModules: [
  ],
  /*
  ** Nuxt.js modules
  */
  modules: [
    // Doc: https://axios.nuxtjs.org/usage
    '@nuxtjs/axios',
  ],
  /*
  ** Axios module configuration
  ** See https://axios.nuxtjs.org/options
  */
  axios: {
  },
  /*
  ** Build configuration
  */
  generate: {
    dir: 'Public'
  },
  build: {
    // publicPath: '',
    transpile: [/^element-ui/],
    extractCSS: true,
    filenames: {
      app: ({ isDev }) => '[name].js',
      chunk: ({ isDev }) => '[name].js',
      css: ({ isDev }) => '[name].css',
      img: ({ isDev }) => '[path][name].[ext]',
      font: ({ isDev }) => '[path][name].[ext]',
      video: ({ isDev }) => '[path][name].[ext]'
    },
    /*
    ** You can extend webpack config here
    */
    extend (config, ctx) {
    }
  }
}
