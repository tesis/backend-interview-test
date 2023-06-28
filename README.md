# Recruitment Task 🧑‍💻👩‍💻

### Notes

- unfortunately I couldn't start the project as it is described, thus I managed it by myself (adding DB and run migrate/seed, thus DatabaseSeeder is modified)
- InvoiceController is under presentation layer, but I think it should be in Api
- Product model is under Products module, Company model under Companies Module (this was one of my vision about how to split modules, but I'm sure you might have different approach)
- Even if I'm familiar with DDD design and I play around with it, I decieded not to use it in this task (as it is written is not mandatory). Reason: I'm more than sure that our approaches might differ too much, thus I skipped it

### Invoice module with approve and reject system as a part of a bigger enterprise system. Approval module exists and you should use it. It is Backend task, no Frontend is needed.
---
Please create your own repository and make it public or invite us to check it.


<table>
<tr>
<td>

- Invoice contains:
  - Invoice number
  - Invoice date
  - Due date
  - Company
    - Name
    - Street Address
    - City
    - Zip code
    - Phone
  - Billed company
    - Name
    - Street Address
    - City
    - Zip code
    - Phone
    - Email address
  - Products
    - Name
    - Quantity
    - Unit Price
    - Total
  - Total price
</td>
<td>
Image just for visualization
<img src="https://templates.invoicehome.com/invoice-template-us-classic-white-750px.png" style="width: auto"; height:100%" />
</td>
</tr>
</table>

### TO DO:
Simple Invoice module which is approving or rejecting single invoice using information from existing approval module which tells if the given resource is approvable / rejectable. Only 3 endpoints are required:
```
  - Show Invoice data, like in the list above
  - Approve Invoice
  - Reject Invoice
```
* In this task you must save only invoices so don’t write repositories for every model/ entity.

* You should be able to approve or reject each invoice just once (if invoice is approved you cannot reject it and vice versa.

* You can assume that product quantity is integer and only currency is USD.

* Proper seeder is located in Invoice module and it’s named DatabaseSeeder

* In .env.example proper connection to database is established.

* Using proper DDD structure is preferred (with elements like entity, value object, repository, mapper / proxy, DTO) but not mandatory.
Unit tests in plus.

* Docker is in docker catalog and you need only do
  ```
  ./start.sh
  ```
  to make everything work

  docker container is in docker folder. To connect with it just:
  ```
  docker compose exec workspace bash
  ```
