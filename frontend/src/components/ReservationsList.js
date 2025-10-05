import React from 'react';
import { Card, Row, Col, Alert } from 'react-bootstrap';
import ReservationItem from './ReservationItem';

const ReservationsList = ({ bookings, onDelete }) => {
    return (
        <Card>
            <Card.Header className="bg-primary text-white">
                <h5 className="mb-0">Reservations list ({bookings.length})</h5>
            </Card.Header>
            <Card.Body>
                {bookings.length === 0 ? (
                    <Alert variant="info">No reservations</Alert>
                ) : (
                    <Row>
                        {bookings.map((booking) => (
                            <Col md={6} lg={4} key={booking.id} className="mb-3">
                                <ReservationItem booking={booking} onDelete={onDelete} />
                            </Col>
                        ))}
                    </Row>
                )}
            </Card.Body>
        </Card>
    );
};

export default ReservationsList;
