<?php include_once "./includes/header.php" ?>


<div class="container">
    <div class="rounded  p-2   col-lg-12   bg-white">
        <h2 class="text-center mb-3">Apply For Adoption</h2>

        <p class="form-warn mb-2 ">Please note that your application cannot be submitted until all fields marked as <span style="color: red;">REQUIRED</span> have been entered.</p>
        <form action="adoption_formhandel.php" method="POST" id="frmsignup">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

            <div class="mb-3">
                <label for="full-label  ">Full Name:</label>
                <!--input li class form controlhoti ha-->
                <input class="form-control " type="text" readonly name="full_name" id="txtfullname" value="<?php echo $_SESSION['userdata']['fullname'] ?> ">
                <div class="message-error" id="fullnameError"></div>
            </div>

            <div class="mb-3  ">
                <label for="email" class="form-label">Email</label>
                <input type="email" readonly class="form-control " id="txtemail" name="email" value="<?php echo $_SESSION['userdata']['email'] ?>">
                <div class="message-error" id="emailError"></div>
            </div>


            <div class="mb-2 form-group">
                <label class="form-label">City</label>
                <!--drop down ky liye select use hota ha -->
                <input type="text" class=" form-control" name="city" id="selectcity" value="Multan" readonly>
                <span class="message-error" id="cityError"></span>
                <div class="message-error" id="cityError"></div>
            </div>
            <div class="mb-3">
                <label for="inquiry" class="form-label">Do you have other pet/pets?</label>
                <input type="text" name="inquiry" id="txtinquiry" class="form-control" required>
                <div class="message-error" id="inquiryError"></div>
            </div>
            <div class="mb-3">
                <label for="inquiry1" class="form-label">Why do you want to adopt a pet? What are your expectations for
                    this adoption?</label>
                <input type="text" name="inquiry1" id="txtinquiry1" class="form-control" required>
                <div class="message-error" id="inquiry1Error"></div>
            </div>
            <div class="mb-3">
                <label for="inquiry2" class="form-label">Do you live in a house or an apartment? Do you own or rent your
                    home?</label>
                <input type="text" name="inquiry2" id="txtinquiry2" class="form-control" required>
                <div class="message-error" id="inquiry2Error"></div>
            </div>
            <div class="mb-3">
                <label for="inquiry3" class="form-label">How many adults and children live in your household? What are
                    their ages? Are there any allergies to pets?</label>
                <input type="text" name="inquiry3" id="txtinquiry3" class="form-control" required>
                <div class="message-error" id="inquiry3Error"></div>
            </div>
            <div class="mb-3">
                <label for="inquiry4" class="form-label">Please describe your home environment, including any yard or
                    living space.</label>
                <input type="text" name="inquiry4" id="txtinquiry4" class="form-control" required>
                <div class="message-error" id="inquiry4Error"></div>
            </div>
            <div class="mb-3">
                <label for="inquiry5" class="form-label">Are you aware of the costs associated with pet ownership,
                    including food, grooming, veterinary care, and unexpected medical expenses? Are you prepared for these
                    financial responsibilities?</label>
                <input type="text" name="inquiry5" id="txtinquiry5" class="form-control" required>
                <div class="message-error" id="inquiry5Error"></div>
            </div>

            <div class="mb-3">
                <label for="inquiry6" class="form-label">Previous experience with pets, currently owned pets, and their
                    species, breed, age, and if they are
                    spayed/neutered.</label>
                <input type="text" name="inquiry6" id="txtinquiry6" class="form-control" required>
                <div class="message-error" id="inquiry6Error"></div>
            </div>

            <div class="mb-3">
                <label for="inquiry7" class="form-label">Are you open to a follow-up home visit after the adoption to
                    ensure that the pet is settling in well?</label>
                <input type="text" name="inquiry7" id="txtinquiry7" class="form-control" required>
                <div class="message-error" id="inquiry7Error"></div>
            </div>

            <div class="mb-3">
                <label for="inquiry8" class="form-label">Agreeing to provide regular updates on the pet's well-being and
                    adjustment to the new home.</label>
                <input type="text" name="inquiry8" id="txtinquiry8" class="form-control" required>
                <div class="message-error" id="inquiry8Error"></div>
            </div>

            <div class=" pt-4 text-right">
                <input type="hidden" name="submit_adoption" value="some_value">
                <button type="submit" class="button btn btn-primary px-4" name="submit_adoption">Submit</button>
            </div>
        </form>
    </div>
</div>


<script>
    function validateForm() {
        const inputElements = {
            txtfullname: document.getElementById('txtfullname'),
            txtemail: document.getElementById('txtemail'),
            selectcity: document.getElementById('selectcity'),
            txtinquiry: document.getElementById('txtinquiry'),
            txtinquiry1: document.getElementById('txtinquiry1'),
            txtinquiry2: document.getElementById('txtinquiry2'),
            txtinquiry3: document.getElementById('txtinquiry3'),
            txtinquiry4: document.getElementById('txtinquiry4'),
            txtinquiry5: document.getElementById('txtinquiry5'),
            txtinquiry6: document.getElementById('txtinquiry6'),
            txtinquiry7: document.getElementById('txtinquiry7'),
            txtinquiry8: document.getElementById('txtinquiry8')
        };

        const emailRegex = /^[a-zA-Z0-9._]+@[a-z]+\.[a-z.]+$/;

        const validationMessages = {
            txtfullname: "Enter Full Name",
            txtemail: "Please enter a valid email",
            selectcity: "Select a city",
            txtinquiry: "Please enter your answer",
            txtinquiry1: "Please enter your answer",
            txtinquiry2: "Please enter your answer",
            txtinquiry3: "Please enter your answer",
            txtinquiry4: "Please enter your answer",
            txtinquiry5: "Please enter your answer",
            txtinquiry6: "Please enter your answer",
            txtinquiry7: "Please enter your answer",
            txtinquiry8: "Please enter your answer"
        };

        let isValid = true;

        Object.values(inputElements).forEach(input => {
            input.classList.remove("is-invalid");
            input.nextElementSibling.innerHTML = "";
        });

        Object.entries(inputElements).forEach(([id, input]) => {
            const value = input.value.trim();

            if (id === "txtemail" && !emailRegex.test(value)) {
                isValid = false;
                // } else if ((id === "txtinquiry" || id === "txtinquiry6")) {
                //     isValid = false;
                // }
            } else if (value === "") {
                isValid = false;
            }

            if (!isValid) {
                input.classList.add("is-invalid");
                input.nextElementSibling.innerHTML = validationMessages[id];
            }
        });

        if (isValid) {
            document.getElementById('frmsignup').submit();
            var formInputs = document.querySelectorAll('#frmsignup input');
            formInputs.forEach(function(input) {
                if (!input.hasAttribute('readonly')) {
                    input.value = "";
                }
            });
        }
    }

    document.getElementById('frmsignup').addEventListener('submit', function(event) {
        event.preventDefault();
        validateForm();

    });
</script>