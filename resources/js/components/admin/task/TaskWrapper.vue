<template>
  <v-container fluid grid-list-xl>
    <v-layout row justify-center wrap>
      <v-flex lg9 sm12 xs12>
        <transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
      </v-flex>

    </v-layout>
  </v-container>
</template>

<script>
import Sidemenu from '$comp/ui/Sidemenu'

export default {
  components: {
    Sidemenu
  },

  data: () => ({
  }),

  mounted() {
  },

  methods: {
  }
}
</script>
