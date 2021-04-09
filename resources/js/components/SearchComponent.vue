<template>
    <el-container style="height: 600px; border: 1px solid #eee">
      <el-aside width="250px">
        <br/>
        <el-col :span="24"  class="p-5">
          <span> Search </span>
          <input :span="12" size="meduim" v-model="search" @change="processFilter()" type="text" placeholder="Type to search" />
        </el-col>

        <el-col :span="24" class="p-5">
          <span> Bedrooms </span>
          <input :span="12" size="meduim" v-model="bedrooms" @change="processFilter()" min=1 type="number" placeholder="# bedrooms" />
        </el-col>

        <el-col :span="24" class="p-5">
          <span> Bathrooms </span>
          <input :span="12" size="meduim" v-model="bathrooms" @change="processFilter()" min=1 type="number" placeholder="# bathrooms" />
        </el-col>

       <el-col :span="24" class="p-5">
          <span> Garages </span>
          <input :span="12" size="meduim" v-model="garages" @change="processFilter()" min=1 type="number" placeholder="# garages" />
        </el-col>

        <el-col :span="24" class="p-5">
          <span> Storeys </span>
          <input :span="12" size="meduim" v-model="storeys" @change="processFilter()" min=1 type="number" placeholder="# storeys" />
        </el-col>



        <el-col :span="24" class="p-5">
          <span> Price Range {{priceRange}} </span>
            <el-slider
              v-model="priceRange"
              range
              :max="price_max"
              @change="processFilter"
              >
            </el-slider>
        </el-col>
        <el-button type="primary" @click="processFilter">SEARCH</el-button>
      </el-aside>
      <el-container>
        <el-main>
            <el-table
              :data="properties"
              v-loading="loading"
              empty-text="No results were found"
              style="width: 100%">

              <el-table-column
                label="Name"
                prop="name">
              </el-table-column>

              <el-table-column
                label="Price"
                prop="price">
              </el-table-column>

              <el-table-column
                label="Bed Rooms"
                prop="bedrooms">
              </el-table-column>

              <el-table-column
                label="Bath Rooms"
                prop="bathrooms">
              </el-table-column>

              <el-table-column
                label="Storeys"
                prop="storeys">
              </el-table-column>

              <el-table-column
                label="Garages"
                prop="garages">
              </el-table-column>

            </el-table>
        </el-main>
      </el-container>
    </el-container>
</template>


<style>
  .p-5 {
    padding: 10px;
  }
</style>
<script>
  export default {

    data() {
      return {
        loading: true,
        properties: null,
        search: '',
        bedrooms: null,
        bathrooms: null,
        garages: null,
        storeys: null,
        price_min: 0,
        price_max: 0,
        priceRange: [],
      }
    },
    mounted(){
         axios.get('/api/properties')
          .then((response) => {
            console.log('resp', response)

            const {price_min, price_max, data} = response.data.property;
            this.properties = data
            this.priceRange = [price_min, price_max]
            this.price_max = price_max
            this.price_min = price_min
            this.loading = false
          })
     },

    methods: {

        processFilter() {
           this.loading = true

            const filterQuerty = this.generateFilterQuery()

            setTimeout(() => {
              axios.get(`/api/properties`,{
                params: filterQuerty
              })
                .then((response) => {
                  this.properties = response.data.property.data
                  this.loading = false
              })
             }, 1000);
        },
        generateFilterQuery(){
           let queryParams = {}

           if (this.search !== "" ){
              queryParams["search"] = this.search
           }

           if (this.bedrooms !== 0 || this.bedrooms !== "" ){
              queryParams["bedrooms"] = this.bedrooms
           }

          if (this.bathrooms !== 0 || this.bathrooms !== null ){
              queryParams["bathrooms"] = this.bathrooms
          }

          if (this.garages !== 0 || this.garages !== null ){
            queryParams["garages"] = this.garages
          }

          if (this.storeys !== 0 || this.storeys !== null ){
            queryParams["storeys"] = this.storeys
          }

          if (this.priceRange.length > 0){
              queryParams["price_min"] = this.priceRange[0]
              queryParams["price_max"] = this.priceRange[1]
          }

          return queryParams;
        }

      }

    }

</script>
