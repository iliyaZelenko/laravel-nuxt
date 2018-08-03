<template>
  <div>
    <v-container fluid grid-list-xl>
      <v-layout row wrap justify-center>
        <v-flex v-for="i in 40" :key="i" xs2>
          <router-link to="#">
            <img :src="`https://randomuser.me/api/portraits/men/${i}.jpg`" class="profile__friend" alt="lorem" width="100%">
            <div class="text-xs-center">
              <b>{{ people[i].name }} {{ people[i].surname }}</b>
            </div>
          </router-link>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
export default {
  data: () => ({
    // ssr не работает если делать апи в mounted, другой вариант(сюдя по документации единственный) был вынести запрос к апи на страницу и передать пропсы сюда
    people: [{'name': 'Samuel', 'surname': 'Wilson', 'gender': 'male', 'region': 'United States'}, {'name': 'Nalan', 'surname': 'Arnas', 'gender': 'female', 'region': 'Turkey'}, {'name': 'Júlia', 'surname': 'Kolár', 'gender': 'male', 'region': 'Slovakia'}, {'name': 'Rob van der', 'surname': 'Linden', 'gender': 'male', 'region': 'Netherlands'}, {'name': 'Κόρακας', 'surname': 'Διαμαντόπουλος', 'gender': 'male', 'region': 'Greece'}, {'name': 'Patricia', 'surname': 'Guerrero', 'gender': 'female', 'region': 'Mexico'}, {'name': 'Guillermina', 'surname': 'Segura', 'gender': 'female', 'region': 'Mexico'}, {'name': 'Γεώργιος', 'surname': 'Παπακωνσταντίνου', 'gender': 'male', 'region': 'Greece'}, {'name': 'Εύμηλος', 'surname': 'Δεσποτόπουλος', 'gender': 'male', 'region': 'Greece'}, {'name': 'Εύανδρος', 'surname': 'Δουρέντης', 'gender': 'male', 'region': 'Greece'}, {'name': 'Timea', 'surname': 'Găină', 'gender': 'female', 'region': 'Romania'}, {'name': 'Františka', 'surname': 'Milota', 'gender': 'female', 'region': 'Slovakia'}, {'name': 'Erwan', 'surname': 'Bernard', 'gender': 'male', 'region': 'France'}, {'name': 'Kanti', 'surname': 'Jaiswal', 'gender': 'female', 'region': 'Nepal'}, {'name': 'Yağmur', 'surname': 'Kemal', 'gender': 'female', 'region': 'Turkey'}, {'name': 'Αριστομένης', 'surname': 'Κουταλιανός', 'gender': 'male', 'region': 'Greece'}, {'name': 'Eliana', 'surname': 'Bănățeanu', 'gender': 'female', 'region': 'Romania'}, {'name': 'Ισμηνίας', 'surname': 'Αλεξανδρίδης', 'gender': 'male', 'region': 'Greece'}, {'name': 'Λυκάων', 'surname': 'Καραμήτσος', 'gender': 'male', 'region': 'Greece'}, {'name': 'Ελλάδιος', 'surname': 'Ελευθερόπουλος', 'gender': 'male', 'region': 'Greece'}, {'name': 'Ujjwol', 'surname': 'Mainali', 'gender': 'male', 'region': 'Nepal'}, {'name': 'Δημόφιλος', 'surname': 'Φραγκούδης', 'gender': 'male', 'region': 'Greece'}, {'name': 'Dominik', 'surname': 'Bača', 'gender': 'male', 'region': 'Slovakia'}, {'name': 'ამირან', 'surname': 'დავითაძე', 'gender': 'male', 'region': 'Georgia'}, {'name': 'Rose', 'surname': 'Stephens', 'gender': 'female', 'region': 'United States'}, {'name': 'Irinel', 'surname': 'Cazan', 'gender': 'male', 'region': 'Romania'}, {'name': 'Luna', 'surname': 'Desmet', 'gender': 'female', 'region': 'Belgium'}, {'name': 'Bohuš', 'surname': 'Feldek', 'gender': 'male', 'region': 'Slovakia'}, {'name': 'Yaren', 'surname': 'Karadağ', 'gender': 'female', 'region': 'Turkey'}, {'name': 'Alena', 'surname': 'Krupa', 'gender': 'female', 'region': 'Slovakia'}, {'name': 'Rachel', 'surname': 'Lucas', 'gender': 'female', 'region': 'United States'}, {'name': 'Bacsó', 'surname': 'Szilvia', 'gender': 'female', 'region': 'Hungary'}, {'name': 'Zaraza', 'surname': 'Aderca', 'gender': 'female', 'region': 'Romania'}, {'name': 'Μενοίτιος', 'surname': 'Αλεβίζος', 'gender': 'male', 'region': 'Greece'}, {'name': '孟', 'surname': '元', 'gender': 'male', 'region': 'China'}, {'name': 'Pánczél', 'surname': 'Hugó', 'gender': 'male', 'region': 'Hungary'}, {'name': 'Μέμνων', 'surname': 'Αλεξάνδρου', 'gender': 'male', 'region': 'Greece'}, {'name': 'Bhim', 'surname': 'Subba', 'gender': 'male', 'region': 'Nepal'}, {'name': 'Lăcrămioara', 'surname': 'Almaș', 'gender': 'female', 'region': 'Romania'}, {'name': 'Lazăr', 'surname': 'Măzărachi', 'gender': 'male', 'region': 'Romania'}, {'name': 'Rubén', 'surname': 'Colín', 'gender': 'male', 'region': 'Mexico'}, {'name': 'Ștefana', 'surname': 'Pârvulescu', 'gender': 'female', 'region': 'Romania'}, {'name': 'Ľubica', 'surname': 'Petruška', 'gender': 'female', 'region': 'Slovakia'}, {'name': 'Anatolie', 'surname': 'Arghezi', 'gender': 'male', 'region': 'Romania'}, {'name': 'Samuel', 'surname': 'Ross', 'gender': 'male', 'region': 'England'}, {'name': 'Ασπάσιος', 'surname': 'Καραμήτσος', 'gender': 'male', 'region': 'Greece'}, {'name': 'Anežka', 'surname': 'Krupa', 'gender': 'female', 'region': 'Slovakia'}, {'name': 'Loïc', 'surname': 'Deprez', 'gender': 'male', 'region': 'Belgium'}, {'name': 'Jennifer', 'surname': 'Valencia', 'gender': 'female', 'region': 'Colombia'}, {'name': 'Ghanashyam', 'surname': 'Shukla', 'gender': 'male', 'region': 'Nepal'}]
  })
}
</script>

<style>
.profile__friend {
  border-radius: 10px;
  transform: rotate(0) scale(1);
  transition: .3s ease-in-out;
}

.profile__friend:hover {
  transform: rotate(2deg) scale(1.1);
}
</style>
