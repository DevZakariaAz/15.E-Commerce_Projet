<script setup>
// Imports
import { ref, onMounted } from "vue";
import { useAuthStore } from "../stores/authStore";
import { useProductsStore } from "../stores/ProductsStore";
import { useForm, Field, Form } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";

import * as z from "zod"; // Zod for schema validation

// Importing components from shadcn/ui and lucide-vue-next
import { Aside } from "@/components/ui/aside";
import { FormLabel } from "@/components/ui/form";
import { Button } from "@/components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Sheet, SheetContent, SheetTrigger } from "@/components/ui/sheet";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { Tabs, TabsContent } from "@/components/ui/tabs";
import { TooltipProvider } from "@/components/ui/tooltip";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import {
    Dialog,
    DialogContent,
    DialogTrigger,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from "@/components/ui/dialog";
import {
    CircleUser,
    File,
    Home,
    MoreHorizontal,
    Package,
    PanelLeft,
    PlusCircle,
} from "lucide-vue-next";

// Stores
const products = useProductsStore();
const authStore = useAuthStore();

// Form validation schema
const formSchema = toTypedSchema(
    z.object({
        name: z.string().min(2).max(50),
        description: z.string().min(2).max(50),
        price: z.number().min(1).max(10000),
    }),
);

// Form state
const { handleSubmit } = useForm({ validationSchema: formSchema });

// Dialog state
const isDialogOpen = ref(false);

// Add product
const onSubmit = async (values) => {
    try {
        await products.addProduct(values);
        isDialogOpen.value = false;
    } catch (error) {
        console.error(error);
    }
};

// Delete product
const deleteProduct = async (productId) => {
    try {
        await products.deleteProduct(productId);
        await products.fetchProducts();
    } catch (error) {
        console.error(error);
    }
};
onMounted(() => {
  products.fetchProducts();
});

// Logout
const logout = async () => await authStore.logout();





const formatPrice = (field, event) => {
  let value = event.target.value;

  // Remove non-numeric characters
  value = value.replace(/[^0-9.]/g, '');

  // Ensure only two decimal places
  const parts = value.split('.');
  if (parts.length > 1) {
    value = `${parts[0]}.${parts[1].slice(0, 2)}`;
  }

  // Update the field value
  field.value = value;
  event.target.value = value;
};
</script>

<template>
        <TooltipProvider>
        <!-- Main container -->
        <div class="flex min-h-screen w-full flex-col bg-muted/40">
            <!-- Sidebar -->
            <Aside />

            <!-- Main content area -->
            <div class="flex flex-col sm:gap-4 sm:py-4 sm:pl-14">
                <!-- Header section -->
                <header
                    class="sticky top-0 z-30 flex h-14 items-center gap-4 border-b bg-background px-4 sm:static sm:h-auto sm:border-0 sm:bg-transparent sm:px-6"
                >
                    <!-- Menu for small screens -->
                    <Sheet>
                        <SheetTrigger as-child>
                            <Button size="icon" variant="outline" class="sm:hidden">
                                <PanelLeft class="h-5 w-5" />
                                <span class="sr-only">Toggle Menu</span>
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="sm:max-w-xs">
                            <nav class="grid gap-6 text-lg font-medium">
                                <!-- Navigation links -->
                                <a href="#" class="flex items-center gap-4 px-2.5 text-muted-foreground hover:text-foreground">
                                    <Home class="h-5 w-5" /> Dashboard
                                </a>
                                <a href="#" class="flex items-center gap-4 px-2.5 text-foreground">
                                    <Package class="h-5 w-5" /> Products
                                </a>
                            </nav>
                        </SheetContent>
                    </Sheet>

                    <!-- User Menu -->
                    <div class="ml-auto"></div>
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="secondary" size="icon" class="rounded-full">
                                <CircleUser class="h-5 w-5" />
                                <span class="sr-only">Toggle user menu</span>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent class ="align-end">
                            <DropdownMenuItem @click="logout"> Logout </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </header>

                <!-- Main tabs and content -->
                <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
                    <!-- Table displaying products -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Products</CardTitle>
                            <CardDescription>
                                Manage your products
                            </CardDescription>

                            <div class="flex items-center">
                                <!-- Actions like exporting data and adding new products -->
                                <div class="ml-auto flex items-center gap-2">
                                    <Button size="sm" variant="outline" class="h-7 gap-1">
                                        <File class="h-3.5 w-3.5" />
                                        <span class="sr-only sm:not-sr-only">Export</span>
                                    </Button>

                                    <!-- Add Product Button -->
                                    <Dialog v-model:open="isDialogOpen">
                                        <DialogTrigger as-child>
                                            <Button size="sm" class="h-7 gap-1">
                                                <PlusCircle class="h-3.5 w-3.5" />
                                                <span class="sr-only sm:not-sr-only">Add Product</span>
                                            </Button>
                                        </DialogTrigger>

                                        <DialogContent>
                                            <DialogHeader>
                                                <DialogTitle>Add New Product</DialogTitle>
                                                <DialogDescription>Fill in the details to add a new product.</DialogDescription>
                                            </DialogHeader>

                                            <!-- Add Product Form -->
                                            <Form :validation-schema="formSchema" @submit="onSubmit" class="space-y-4">
                                            <!-- Product Name Field -->
                                            <Field name="name">
                                                <template #default="{ field, meta }">
                                                <div class="space-y-1">
                                                    <FormLabel for="name">Product Name</FormLabel>
                                                    <div class="relative">
                                                    <Input
                                                        v-bind="field"
                                                        type="text"
                                                        placeholder="Enter product name"
                                                        id="name"
                                                        :class="{ 'border-red-500': meta.touched && meta.error }"
                                                    />
                                                    <span
                                                        v-if="meta.touched && meta.error"
                                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-red-500"
                                                    >
                                                        <i class="fas fa-exclamation-circle"></i> <!-- Error icon -->
                                                    </span>
                                                    </div>
                                                    <span v-if="meta.touched && meta.error" class="text-sm text-red-500">
                                                    {{ meta.error }}
                                                    </span>
                                                </div>
                                                </template>
                                            </Field>

                                            <!-- Product Description Field -->
                                            <Field name="description">
                                                <template #default="{ field, meta }">
                                                <div class="space-y-1">
                                                    <FormLabel for="description">Product Description</FormLabel>
                                                    <Textarea
                                                    v-bind="field"
                                                    placeholder="Enter product description"
                                                    id="description"
                                                    :class="{ 'border-red-500': meta.touched && meta.error }"
                                                    />
                                                    <span v-if="meta.touched && meta.error" class="text-sm text-red-500">
                                                    {{ meta.error }}
                                                    </span>
                                                </div>
                                                </template>
                                            </Field>

                                            <!-- Product Price Field -->
                                            <Field name="price">
                                                <template #default="{ field, meta }">
                                                <div class="space-y-1">
                                                    <FormLabel for="price">Product Price</FormLabel>
                                                    <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500">$</span> <!-- Currency symbol -->
                                                    </div>
                                                    <Input
                                                        v-bind="field"
                                                        type="text" 
                                                        placeholder="0.00"
                                                        id="price"
                                                        :class="{ 'border-red-500': meta.touched && meta.error, 'pl-7': true }"
                                                        @input="formatPrice(field, $event)"
                                                    />
                                                    <span
                                                        v-if="meta.touched && meta.error"
                                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-red-500"
                                                    >
                                                        <i class="fas fa-exclamation-circle"></i> <!-- Error icon -->
                                                    </span>
                                                    </div>
                                                    <span v-if="meta.touched && meta.error" class="text-sm text-red-500">
                                                    {{ meta.error }}
                                                    </span>
                                                </div>
                                                </template>
                                            </Field>

                                            <!-- Submit Button -->
                                            <Button type="submit" class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                                                Add Product
                                            </Button>
                                            </Form>                                        
                                        </DialogContent>
                                    </Dialog>
                                </div>
                            </div>
                        </CardHeader>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Product</TableHead>
                                    <TableHead>Description</TableHead>
                                    <TableHead>Price</TableHead>
                                    <TableHead>Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="product in products.data" :key="product.id">
                                    <TableCell>{{ product.name }}</TableCell>
                                    <TableCell>{{ product.description }}</TableCell>
                                    <TableCell>{{ product.price }}</TableCell>
                                    <TableCell>
                                        <!-- Edit Button -->
                                        <Button variant="outline" @click="editProduct(product)" class="bg-blue-500 hover:bg-blue-600 text-white">
                                            Edit
                                        </Button>
                                        <!-- Show Button -->
                                        <Button variant="outline" @click="showProduct(product)" class="bg-green-500 hover:bg-green-600 text-white">
                                            Show
                                        </Button>
                                        <!-- Delete Button -->
                                        <Button variant="outline" @click="deleteProduct(product.id)" class="bg-red-500 hover:bg-red-600 text-white">
                                            Delete
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </Card>
                </main>
            </div>
        </div>
        </TooltipProvider>
</template>
