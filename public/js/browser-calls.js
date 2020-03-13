var answerButton = $(".answer-button");

// Twilio.Device.incoming(function(connection) {
//   console.log("Incoming support call");

//   // Set a callback to be executed when the connection is accepted
//   connection.accept(function() {
//     console.log("In call with customer");
//   });

//   // Set a callback on the answer button and enable it
//   answerButton.click(function() {
//       connection.accept();
//   });
//   answerButton.prop("disabled", false);
// });

// Twilio.Device.ready(function (device) {
//   console.log("Ready");
// });

// /* Report any errors to the call status display */
// Twilio.Device.error(function (error) {
//   console.log("ERROR: " + error.message);
// });

// Twilio.Device.connect(function (connection) {

//   // If phoneNumber is part of the connection, this is a call from a
//   // support agent to a customer's phone
//   if ("phoneNumber" in connection.message) {
//       console.log("In call with " + connection.message.phoneNumber);
//   } else {
//       // This is a call from a website user to a support agent
//       console.log("In call with support");
//   }
// });
