// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })
import Mailbox from '../features/Mailbox'

Cypress.Commands.add('safeClick', { prevSubject: 'element'}, (element) => {
    cy.visit(element.prop('href'));

    return;
})

Cypress.Commands.add('login', (userEmail) => {
    cy.session([userEmail], () => {
        cy.visit('/')

        cy.findByText('Sign in').click()

        cy.findByTestId('magic_link_email').type(userEmail)

        cy.findByText('Send me a magic link', {exact: false}).click()

        cy.contains('Your link is on its way!')

        Mailbox.shouldHaveEmailCount(1)

        Mailbox.getFirstEmail().then(email => {
            cy.expect(email.Subject).to.eq('Sign in to monitortoise')
            cy.expect(email.To.length).to.eq(1)
            cy.expect(email.To[0].Address).to.eq('gabriel@tentacode.test')
            
            cy.visit(Mailbox.getCtaUrl(email))

            cy.findByText('My account').safeClick()

            cy.contains('Add a link')
        })
    })
  })
