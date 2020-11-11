<template>
  <div>
    <h2 class="mb-4 primary--text headline">Ваш Профиль</h2>

    <v-card>
      <v-card-text>

        <v-text-field
          label="Логин"
          v-model="user.login"
          filled
          readonly
          hide-details
          class="mb-2"
        ></v-text-field>

        <v-text-field
          label="Имя"
          v-model="user.name"
          filled
          readonly
          hide-details
          class="mb-2"
        ></v-text-field>

        <v-text-field
          label="Отчество"
          v-model="user.surname"
          filled
          readonly
          hide-details
          class="mb-2"
        ></v-text-field>

        <v-text-field
          label="Фамилия"
          v-model="user.family"
          filled
          readonly
          hide-details
          class="mb-2"
        ></v-text-field>

        <v-text-field
          label="Должность"
          v-model="this.getUserRole()"
          filled
          readonly
          hide-details
          class="mb-2"
        ></v-text-field>

      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {settings} from '~/config'

export default {
  data: () => ({
    user: {
      name: null,
      login: null,
      family: null,
      surname: null,
      role: null,
    },
  }),

  computed: mapGetters({
    auth: 'auth/user',
  }),

  methods: {
    getUserRole() {
      return settings.userRole.title[this.user.role]
    }
  },

  mounted() {
    this.user = Object.assign(this.user, this.auth)
  }
}
</script>
