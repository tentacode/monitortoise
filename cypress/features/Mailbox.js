class Mailbox
{
    static deleteAllEmails() {
        cy.request('DELETE', 'http://localhost:8025/api/v1/messages')
    }

    static shouldHaveEmailCount(count) {
        cy.request('GET', 'http://localhost:8025/api/v1/messages').then(response => {
            expect(response.body.total).to.eq(count)
        })
    }

    static getFirstEmail() {
        return cy.request('GET', 'http://localhost:8025/api/v1/messages').then(response => {
            const emailId = response.body.messages[0].ID;

            return cy.request('GET', `http://localhost:8025/api/v1/message/${emailId}`).then(response => {
                return response.body;
            })
        })
    }

    static getCtaUrl(email) {
        const htmlContent = email.HTML;
        const parser = new DOMParser();
        const doc = parser.parseFromString(htmlContent, 'text/html');
        const link = doc.querySelector('a[data-testid="email_cta"]');
        const href = link ? link.getAttribute('href') : null;

        return href;
    }
}

export default Mailbox