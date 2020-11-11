const siteUrl = $config.siteUrl
const apiUrl = $config.apiUrl

export const settings = {
  locale: $config.locale,
  siteName: $config.siteName,
  userRole: {
    title: [
      'Работник',
      'Руководитель',
    ],
    worker: 0,
    manager: 1,
  },
  taskStatus: {
    title:[
      'К выполнению',
      'Выполняется',
      'Выполнена',
      'Отменена',
    ],
    created: 0,
    in_progress: 1,
    done: 2,
    canceled: 3,
  },
  taskPriority: {
    title:[
      'Низкий',
      'Средний',
      'Высокий',
    ],
    low: 0,
    middle: 1,
    high: 2,
  }

}

class URL {
  constructor(base) {
    this.base = base
  }

  path(path, args) {
    path = path.split('.')
    let obj = this,
      url = this.base

    for (let i = 0; i < path.length && obj; i++) {
      if (obj.url) {
        url += '/' + obj.url
      }

      obj = obj[path[i]]
    }
    if (obj) {
      url = url + '/' + (typeof obj === 'string' ? obj : obj.url)
    }

    if (args) {
      for (let key in args) {
        url = url.replace(':' + key, args[key])
      }
    }

    return url
  }
}

export const api = Object.assign(new URL(apiUrl), {
  url: '',

  login: {
    url: 'login',
  },

  logout: 'logout',

  register: 'register',

  me: {
    url: 'user/me',
  },

  task: {
    url: 'task'
  },

  profile: {
    url: 'profile'
  }
})
