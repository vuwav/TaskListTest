<template>
  <v-form ref="form" @submit.prevent="submit" lazy-validation v-model="valid">
    <v-text-field
      :label="labels.login"
      v-model="form.login"
      type="login"
      :error-messages="errors.login"
      :counter="4"
      :rules="[rules.required('login')]"
      :disabled="loading"
      prepend-icon="person"
      @input="clearErrors('login')"
    ></v-text-field>

    <v-text-field
      :label="labels.password"
      v-model="form.password"
      :append-icon="passwordHidden ? 'visibility_off' : 'visibility'"
      @click:append="() => (passwordHidden = !passwordHidden)"
      :type="passwordHidden ? 'password' : 'text'"
      :error-messages="errors.password"
      :counter="8"
      :disabled="loading"
      :rules="[rules.required('password')]"
      prepend-icon="lock"
      @input="clearErrors('password')"
    ></v-text-field>

    <v-layout class="mt-4 mx-0">
      <v-spacer></v-spacer>

      <v-btn
        type="submit"
        :loading="loading"
        :disabled="loading || !valid"
        color="primary"
        class="ml-4"
      >
        Войти
      </v-btn>
    </v-layout>
  </v-form>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'
import Form from '~/mixins/form'

export default {
  mixins: [Form],

  data: () => ({
    passwordHidden: true,

    form: {
      login: null,
      password: null
    }
  }),

  created() {
    this.form.login = this.$route.query.login || null
  },

  methods: {
    submit() {
      if (this.$refs.form.validate()) {
        this.loading = true

        axios.post(api.path('login'), this.form)
          .then(res => {
            this.$toast.success(res.data.message)
            this.$emit('success', res.data)
          })
          .catch(err => {
            this.handleErrors(err.response.data.message)
          })
          .then(() => {
            this.loading = false
          })
      }
    },
  }
}
</script>
