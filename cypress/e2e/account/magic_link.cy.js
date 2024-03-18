import Mailbox from '../../features/Mailbox'

describe('magic link', () => {
    beforeEach(() => {
        Mailbox.deleteAllEmails()
    })

    it('can sign in with an existing account', () => {
        cy.visit('/')

        cy.findByText('Sign in').click()

        cy.findByTestId('magic_link_email').type('gabriel@tentacode.test')

        cy.findByText('Send me a magic link', {exact: false}).click()

        cy.contains('Your link is on its way!')

        Mailbox.shouldHaveEmailCount(1)

        Mailbox.getFirstEmail().then(email => {
            cy.expect(email.Subject).to.eq('Sign in to monitortoise')
            cy.expect(email.To.length).to.eq(1)
            cy.expect(email.To[0].Address).to.eq('gabriel@tentacode.test')
            
            cy.visit(Mailbox.getCtaUrl(email))

            cy.findByText('My account').safeClick()

            cy.contains('Connecté en tant que tentacode.')
        })
    })
  })