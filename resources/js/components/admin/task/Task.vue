<template>
  <div>

    <v-data-table
      :headers="headers"
      :items="tasks"
      sort-by="created_at"
      sort-desc
      multi-sort
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar>
          <v-toolbar flat color="dark">
            <v-toolbar-title class="mr-7">Задачи</v-toolbar-title>
            <div class="flex-grow-1"></div>
          </v-toolbar>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn
                color="primary"
                dark
                class="mb-2"
                v-on="on"
              >
                Новая Задача
              </v-btn>
            </template>
            <v-card>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-text-field
                      v-model="editedItem.title"
                      name="title"
                      label="Название"
                      hide-details
                      class="mb-2"
                    ></v-text-field>
                  </v-row>
                  <v-row>
                    <v-textarea
                      v-model="editedItem.description"
                      name="description"
                      label="Описание"
                    ></v-textarea>
                  </v-row>
                  <v-row>
                    <v-select
                      name="worker_id"
                      :items="user.workers || [{text: 'Я', value: user.id}]"
                      v-model="editedItem.worker_id"
                      label="Ответственный"
                    ></v-select>
                  </v-row>
                  <v-row>
                    <v-select
                      name="priority"
                      :items="priority"
                      v-model="editedItem.priority"
                      label="Приоритет"
                    ></v-select>
                  </v-row>
                  <v-row>
                    <v-select
                      name="status"
                      :items="status"
                      v-model="editedItem.status"
                      label="Статус"
                    ></v-select>
                  </v-row>
                  <v-row>
                    <v-menu
                      ref="menu"
                      v-model="menu"
                      :close-on-content-click="false"
                      :return-value.sync="editedItem.done_at"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="editedItem.done_at"
                        label="Выполнить к"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>

                      <v-date-picker
                        v-model="editedItem.done_at"
                        no-title
                        scrollable
                      >
                        <v-spacer></v-spacer>
                        <v-btn
                          text
                          color="primary"
                          @click="menu = false"
                        >
                          Отмена
                        </v-btn>
                        <v-btn
                          text
                          color="primary"
                          @click="$refs.menu.save(editedItem.done_at)"
                        >
                          OK
                        </v-btn>
                      </v-date-picker>
                    </v-menu>
                  </v-row>

                </v-container>
              </v-card-text>

              <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn color="blue darken-1" text @click="close">Отмена</v-btn>
                <v-btn color="blue darken-1" text @click="save">Сохранить</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>

      <template v-slot:item.title="{ item }">
        <v-chip
          :color=getTitleColor(item)
        >{{ item.title }}
        </v-chip>
      </template>

      <template v-slot:item.status="{ item }">
        <v-chip
          dark
        >{{ settings.taskStatus.title[item.status] }}
        </v-chip>
      </template>

      <template v-slot:item.priority="{ item }">
        <v-chip
          dark
        >{{ settings.taskPriority.title[item.priority] }}
        </v-chip>
      </template>

      <template v-slot:item.created_at="{ item }">
        <span>{{ getDate(item.created_at) }}</span>
      </template>

      <template v-slot:item.done_at="{ item }">
        <span>{{ getDate(item.done_at) }}</span>
      </template>

      <template v-slot:item.updated_at="{ item }">
        <span>{{ getDate(item.updated_at) }}</span>
      </template>

      <template v-slot:item.actions="{ item }">
        <v-icon
          small
          class="mr-2"
          @click="editItem(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon
          small
          @click="deleteItem(item)"
        >
          mdi-delete
        </v-icon>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {api, settings} from '~/config'
import axios from "axios";

export default {
  data: () => ({
    menu: false,
    dialog: false,
    user: {
      name: null,
      email: null,
      role: null,
    },
    headers: [
      {text: 'Действия', value: 'actions', sortable: false},
      {text: "Навание", value: "title"},
      {text: "Статус", value: "status"},
      {text: "Пироритет", value: "priority"},
      {text: "Создана", value: "created_at"},
      {text: "Сделать к", value: "done_at"},
      {text: "Обновлена", value: "updated_at"},
    ],
    tasks: [],
    status: [
      {text: "К выполниению", value: settings.taskStatus.created},
      {text: "Выполняется", value: settings.taskStatus.in_progress},
      {text: "Выполнена", value: settings.taskStatus.done},
      {text: "Отменена", value: settings.taskStatus.canceled},
    ],
    priority: [
      {text: "Низкий", value: settings.taskPriority.low},
      {text: "Средний", value: settings.taskPriority.middle},
      {text: "Высокий", value: settings.taskPriority.high},
    ],
    workers: [],
    settings: [],
    editedIndex: -1,
    editedItem: {
    },
    defaultItem: {
    },
  }),

  computed: mapGetters({
    auth: 'auth/user'
  }),

  methods: {

    editItem(item) {
      this.editedIndex = this.tasks.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },
    deleteItem(item) {
      this.editedIndex = this.tasks.indexOf(item)
      this.editedItem = Object.assign({}, item)
      if (confirm('Вы действительно хотите удалить задачу?')) {
        axios
          .delete('/' + api.path('task') + '/' + item.id)
          .then(response => {
            this.$toast.success(response.data.message)
            this.tasks.splice(this.editedIndex, 1)
          })
          .catch(error => {
            this.$toast.error('Ошибка' + error.data.message);
          });
      }
    },

    close() {
      this.dialog = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },
    save() {
      if (this.editedIndex > -1) {
        let index = this.editedIndex
        let postData = this.editedItem
        postData.manager_id = this.user.manager_id
        postData.done_at = this.getTimeStamp(postData.done_at)
        axios
          .put('/' + api.path('task') + '/' + this.editedItem.id, postData)
          .then(response => {
            Object.assign(this.tasks[this.editedIndex], this.editedItem)
            this.$toast.success('Задача обновлена');
          })
      } else {
        let postData = this.editedItem
        postData.manager_id = this.user.manager_id
        postData.done_at = this.getTimeStamp(postData.done_at)

        axios
          .post('/' + api.path('task'), postData)
          .then(response => {
            this.$toast.success('Задача добавлена');
            this.tasks.push(response.data.task)
          })
      }
      this.close()
    },

    getDate(date) {
      return date && new Date(date).toLocaleString(settings.locale)
    },
    getTimeStamp(date) {
      return new Date(date).toISOString().slice(0, 19).replace('T', ' ');
    },
    getTitleColor(item) {
      if (item.status === settings.taskStatus.done) {
        return 'green';
      }

      let doneDate = item.done_at && new Date(item.done_at);

      if (doneDate && doneDate < (new Date())) {
        return 'red';
      }
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  mounted() {
    axios
      .get('/' + api.path('task'))
      .then(response => {
        this.tasks = response.data.tasks;
      })
      .catch(error => {
        this.$toast.error("Ошибка");
      });
    this.settings = settings
    this.user = Object.assign(this.user, this.auth)
    if (this.user.role === settings.userRole.manager) {
      this.headers.push({text: "Вполняет", value: "user.name"})
      if(this.user.workers === undefined){
        window.location.reload()
      }
    }
    if (this.user.role === settings.userRole.worker) {
      this.headers.push({text: "Руководитель", value: "manager.name"})
    }
  }
}
</script>
