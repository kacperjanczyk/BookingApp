import React, { useState, useEffect } from 'react';
import { Container, Row, Col, Navbar, Spinner, Alert } from 'react-bootstrap';
import ReservationForm from './components/ReservationForm';
import ReservationsList from './components/ReservationsList';
import { getReservations, createReservation, deleteReservation } from './services/api';

function App() {
    const [bookings, setBookings] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetchBookings();
    }, []);

    const fetchBookings = async () => {
        try {
            setLoading(true);
            const response = await getReservations();
            console.log(response)
            setBookings(response.data.data);
            setError(null);
        } catch (err) {
            setError('Unable to fetch reservations');
            console.error(err);
        } finally {
            setLoading(false);
        }
    };

    const handleCreateBooking = async (data) => {
        try {
            await createReservation(data);
            await fetchBookings();
        } catch (err) {
            setError('Unable to create reservation');
            throw err;
        }
    };

    const handleDeleteBooking = async (id) => {
        if (window.confirm('Are you sure you want to delete this reservation?')) {
            try {
                await deleteReservation(id);
                await fetchBookings();
            } catch (err) {
                setError('Unable to delete reservation');
                console.error(err);
            }
        }
    };

    return (
        <div className="App">
            <Navbar bg="dark" variant="dark" className="mb-4">
                <Container>
                    <Navbar.Brand>
                        <h3 className="mb-0">Booking App</h3>
                    </Navbar.Brand>
                </Container>
            </Navbar>

            <Container>
                {error && (
                    <Alert variant="danger" dismissible onClose={() => setError(null)}>
                        {error}
                    </Alert>
                )}

                <Row>
                    <Col lg={4} className="mb-4">
                        <ReservationForm onBookingCreated={handleCreateBooking} />
                    </Col>

                    <Col lg={8}>
                        {loading ? (
                            <div className="text-center p-5">
                                <Spinner animation="border" role="status">
                                    <span className="visually-hidden">Loading...</span>
                                </Spinner>
                            </div>
                        ) : (
                            <ReservationsList bookings={bookings} onDelete={handleDeleteBooking} />
                        )}
                    </Col>
                </Row>
            </Container>
        </div>
    );
}

export default App;
