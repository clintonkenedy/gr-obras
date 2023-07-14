<template>
  <q-layout view="hHh Lpr lff">
    <q-header elevated :class="$q.dark.isActive ? 'bg-secondary text-primary' : 'bg-primary text-white'">
      <q-toolbar>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />

        <q-toolbar-title>

          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
          </q-avatar>
          SISOBRAS
        </q-toolbar-title>
        <SwitchDark></SwitchDark>
        <q-btn type="submit" @click="logout" label="Salir" outline :class="$q.dark.isActive ? 'secondary' : 'primary'" />
      </q-toolbar>
    </q-header>

    <q-drawer v-model="drawer" show-if-above :mini="!drawer || miniState" @click.capture="drawerClick" mini-to-overlay
      :width="$q.screen.width < 500 ? 250 : $q.screen.width > 900 ? 330 : 300" :breakpoint="500" bordered
      :class="$q.dark.isActive ? 'bg-grey-9' : 'bg-grey-3'">
      <q-scroll-area class="fit" :horizontal-thumb-style="{ opacity: 0 }">
        <q-list padding class="text-grey-8">
          <q-expansion-item icon="mdi-account-lock" label="Seguridad y Acceso">
            <q-item :to="{ name: 'Permisos' }" clickable v-ripple :active="link === 'inbox'" @click="link = 'inbox'"
              :inset-level="0.5" active-class="bg-primary text-white">
              <q-item-section avatar>
                <q-icon name="vpn_key" />
              </q-item-section>

              <q-item-section>Permisos</q-item-section>
            </q-item>
            <q-item :to="{ name: 'Roles' }" clickable v-ripple :active="link === 'roles'" @click="link = 'roles'"
              :inset-level="0.5" active-class="bg-primary text-white">
              <q-item-section avatar>
                <q-icon name="vpn_key" />
              </q-item-section>

              <q-item-section>Roles</q-item-section>
            </q-item>
            <q-item :to="{ name: 'Profesiones' }" clickable v-ripple :active="link === 'Profesiones'" @click="link = 'Profesiones'"
              :inset-level="0.5" active-class="bg-primary text-white">
              <q-item-section avatar>
                <q-icon name="vpn_key" />
              </q-item-section>

              <q-item-section>Profesiones</q-item-section>
            </q-item>
          </q-expansion-item>


          <q-item clickable v-ripple :active="link === 'outbox'" @click="link = 'outbox'"
            active-class="bg-primary text-white">
            <q-item-section avatar>
              <q-icon name="send" />
            </q-item-section>

            <q-item-section>Outbox</q-item-section>
          </q-item>




          <q-separator />

          <q-item clickable v-ripple :active="link === 'settings'" @click="link = 'settings'"
            active-class="bg-primary text-white">
            <q-item-section avatar>
              <q-icon name="settings" />
            </q-item-section>

            <q-item-section>Settings</q-item-section>
          </q-item>
        </q-list>
      </q-scroll-area>
      <div class="q-mini-drawer-hide absolute" style="top: 200px; right: -17px">
        <q-btn dense round unelevated color="accent" icon="chevron_left" @click="miniState = true" />
      </div>
    </q-drawer>



    <q-page-container @click="miniState = true">

      <router-view />




    </q-page-container>


  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { useUserStore } from 'src/stores/user-store';
import { useRouter } from 'vue-router';
import SwitchDark from 'src/components/SwitchDark.vue';
// import SwitchDark from 'components/SwitchDark.vue';

const $q = useQuasar()
const userStore = useUserStore()
const router = useRouter()


const drawer = ref(false);
const miniState = ref(true);

const link = ref('');


const drawerClick = (e) => {
  console.log($q.screen.width)
  if (miniState.value) {
    miniState.value = false
    e.stopPropagation()
  }
}

const logout = async () => {
  await userStore.logout();
  // router.push('/');
  router.push({ name: 'Login' })

}


</script>

<style lang="css">
.my-menu-link {
  color: white;
  background: #1976d2;
}
</style>
