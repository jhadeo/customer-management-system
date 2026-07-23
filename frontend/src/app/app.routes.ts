import { Routes } from '@angular/router';
import { Customers } from './pages/customers/customers';
import { CustomerDetail } from './pages/customer-detail/customer-detail';
import { CustomerForm } from './pages/customer-form/customer-form';

export const routes: Routes = [
  {
    path: '',
    redirectTo: 'customers',
    pathMatch: 'full'
  },
  {
    path: 'customers',
    component: Customers
  },
  {
    path: 'customers/new',
    component: CustomerForm
  },
  {
    path: 'customers/:id',
    component: CustomerDetail
  },
  {
    path: 'customers/:id/edit',
    component: CustomerForm
  }
];