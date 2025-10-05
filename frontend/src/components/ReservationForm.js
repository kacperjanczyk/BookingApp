import React, { useState } from 'react';
import { Form, Button, Card, Alert } from 'react-bootstrap';

const ReservationForm = ({ onBookingCreated }) => {
    const [formData, setFormData] = useState({
        name: '',
        surname: '',
        email: '',
        phoneNumber: '',
        startDate: '',
        endDate: '',
    });
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [success, setSuccess] = useState(false);

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError(null);
        setSuccess(false);

        try {
            const dataToSend = {
                ...formData,
                startDate: Math.floor(new Date(formData.startDate).getTime() / 1000),
                endDate: Math.floor(new Date(formData.endDate).getTime() / 1000),
            };
            await onBookingCreated(dataToSend);
            setFormData({
                name: '',
                surname: '',
                email: '',
                phoneNumber: '',
                startDate: '',
                endDate: '',
            });
            setSuccess(true);
            setTimeout(() => setSuccess(false), 3000);
        } catch (error) {
            setError('Unable to create reservation');
            console.error('Reservation create error:', error);
        } finally {
            setLoading(false);
        }
    };

    return (
        <Card>
            <Card.Header className="bg-primary text-white">
                <h5 className="mb-0">New Reservation</h5>
            </Card.Header>
            <Card.Body>
                {error && <Alert variant="danger">{error}</Alert>}
                {success && <Alert variant="success">Reservation successfully created!</Alert>}

                <Form onSubmit={handleSubmit}>
                    <Form.Group className="mb-3">
                        <Form.Label>Name</Form.Label>
                        <Form.Control
                            type="text"
                            name="name"
                            value={formData.name}
                            onChange={handleChange}
                            required
                            placeholder="John"
                        />
                    </Form.Group>

                    <Form.Group className="mb-3">
                        <Form.Label>Surname</Form.Label>
                        <Form.Control
                            type="text"
                            name="surname"
                            value={formData.surname}
                            onChange={handleChange}
                            required
                            placeholder="Doe"
                        />
                    </Form.Group>

                    <Form.Group className="mb-3">
                        <Form.Label>Email</Form.Label>
                        <Form.Control
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            required
                            placeholder="john@example.com"
                        />
                    </Form.Group>

                    <Form.Group className="mb-3">
                        <Form.Label>Phone</Form.Label>
                        <Form.Control
                            type="tel"
                            name="phoneNumber"
                            value={formData.phoneNumber}
                            onChange={handleChange}
                            required
                            placeholder="+48123456789"
                        />
                    </Form.Group>

                    <Form.Group className="mb-3">
                        <Form.Label>Start date</Form.Label>
                        <Form.Control
                            type="date"
                            name="startDate"
                            value={formData.startDate}
                            onChange={handleChange}
                            required
                        />
                    </Form.Group>

                    <Form.Group className="mb-3">
                        <Form.Label>End date</Form.Label>
                        <Form.Control
                            type="date"
                            name="endDate"
                            value={formData.endDate}
                            onChange={handleChange}
                            required
                        />
                    </Form.Group>

                    <Button variant="primary" type="submit" disabled={loading} className="w-100">
                        {loading ? 'Creating...' : 'Create Reservation'}
                    </Button>
                </Form>
            </Card.Body>
        </Card>
    );
};

export default ReservationForm;
