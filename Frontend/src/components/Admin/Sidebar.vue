<template>
   <ul class="navbar-nav bg-light sidebar sidebar-light accordion border-end" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <router-link
         :to="{ name: 'admin.dashboard' }"
         class="sidebar-brand d-flex align-items-center justify-content-center border-bottom"
      >
         <div class="sidebar-brand-text">CA<span style="color: #1cc88f">R</span>ENTAL</div>
      </router-link>

      <!-- Divider -->
      <hr class="sidebar-divider my-0" />

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active border-bottom">
         <router-link class="nav-link text-success" :to="{ name: 'admin.dashboard' }">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
         </router-link>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider" />

      <div class="sidebar-heading text-success">Management</div>

      <li class="nav-item border-bottom">
         <a
            class="nav-link collapsed fw-bold text-dark"
            href="#"
            data-toggle="collapse"
            data-target="#collapseOne"
            aria-expanded="true"
            aria-controls="collapseOne"
         >
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span>
         </a>
         <div
            id="collapseOne"
            class="collapse"
            aria-labelledby="headingOne"
            data-parent="#accordionSidebar"
         >
            <div class="bg-white py-2 collapse-inner rounded">
               <h6 class="collapse-header">Action</h6>
               <router-link class="collapse-item" :to="{ name: 'admin.users' }">
                  <span class="ml-3">User List</span></router-link
               >
            </div>
         </div>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item border-bottom">
         <a
            class="nav-link collapsed fw-bold text-dark"
            href="#"
            data-toggle="collapse"
            data-target="#collapseThree"
            aria-expanded="true"
            aria-controls="collapseThree"
         >
            <i class="fas fa-fw fa-car"></i>
            <span>Homestays</span>
         </a>
         <div
            id="collapseThree"
            class="collapse"
            aria-labelledby="headingThree"
            data-parent="#accordionSidebar"
         >
            <div class="bg-white py-2 collapse-inner rounded">
               <h6 class="collapse-header">Action</h6>
               <router-link :to="{ name: 'admin.cars' }" class="collapse-item">
                  <span class="ml-3">Car List</span>
               </router-link>
               <router-link :to="{ name: 'admin.features' }" class="collapse-item">
                  <span class="ml-3">Features</span>
               </router-link>
            </div>
         </div>
      </li>

      <li class="nav-item border-bottom">
         <router-link :to="{ name: 'admin.blogs' }" class="nav-link fw-bold text-dark">
            <i class="fa-solid fa-square-rss"></i>
            <span>Blog</span>
         </router-link>
      </li>

      <li class="nav-item border-bottom">
         <a
            class="nav-link fw-bold text-danger"
            data-bs-toggle="modal"
            data-bs-target="#logoutModal"
            style="cursor: pointer"
         >
            <i class="fa-solid fa-arrow-right-from-bracket text-danger"></i>
            <span>Logout</span>
         </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider" />
   </ul>
</template>

<script>
export default {
   name: "MainSidebar",
};
</script>

<style></style>
